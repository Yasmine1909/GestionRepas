<?php
namespace App\Imports;

use App\Models\User;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;


class UsersImport
{
    public function import($filePath)
    {
        // Load the Excel file
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, true);

        // Check if the header row exists and extract column names
        $header = array_shift($rows); // Remove and get the header row
        $emailColumn = array_search('email', array_map('strtolower', $header)); // Find the email column

        if ($emailColumn === false) {
            throw new \Exception('No "email" column found in the provided Excel file.');
        }

        // Collect emails from the file, convert to lowercase
        $emailsFromFile = [];
        foreach ($rows as $row) {
            $email = isset($row[$emailColumn]) ? strtolower(trim($row[$emailColumn])) : null;
            if ($email) {
                $emailsFromFile[] = $email;

                // Search for the user in LDAP using email
                $ldapUser = LdapUser::where('mail', '=', $email)->first();

                if ($ldapUser) {
                    $objectGuid = $ldapUser->getConvertedGuid();
                    // Create or update the local user with information from LDAP
                    User::updateOrCreate(
                        ['email' => $email],
                        [
                            'id' => $objectGuid,
                            'name' => $ldapUser->cn[0] ?? 'Unknown',
                            'last_name' => $ldapUser->sn[0] ?? 'Unknown',
                            'password' => bcrypt(Str::random(16)),
                        ]
                    );
                }
            }
        }

        // Delete users not present in the imported file, using lowercase comparison
        User::whereNotIn('email', $emailsFromFile)->delete();
    }
}
