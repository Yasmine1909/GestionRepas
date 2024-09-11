<?php

namespace App\Imports;

use App\Models\User;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UsersImport
{

    public function import($filePath)
    {
        // Load the Excel file
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, true);

        // Extract the column mappings (header row)
        $header = array_shift($rows); // Remove and get the header row
        $emailColumn = array_search('email', array_map('strtolower', $header));
        $typeColumn = array_search('type', array_map('strtolower', $header)); // Find the type column

        if ($emailColumn === false || $typeColumn === false) {
            throw new \Exception('Les colonnes "email" ou "type" sont manquantes dans le fichier Excel.');
        }

        // Process each row from the file
        $emailsFromFile = [];
        foreach ($rows as $row) {
            $email = isset($row[$emailColumn]) ? strtolower(trim($row[$emailColumn])) : null;
            $type = isset($row[$typeColumn]) ? strtolower(trim($row[$typeColumn])) : 'user';

            // Log the values for debugging
            Log::info("Email: $email, Type from file: $type");

            // Validate type, default to 'user' if type is invalid
            if (!in_array($type, ['user', 'admin'])) {
                $type = 'user'; // Ensure default
            }

            if ($email) {
                $emailsFromFile[] = $email;

                // Search for the user in LDAP using email
                $ldapUser = LdapUser::where('mail', '=', $email)->first();

                if ($ldapUser) {
                    $objectGuid = $ldapUser->getConvertedGuid();

                    // Ensure we update or create the local user with the correct "type"
                    $localUser = User::updateOrCreate(
                        ['email' => $email], // Lookup by email
                        [
                            'id' => $objectGuid,
                            'name' => $ldapUser->cn[0] ?? 'Unknown',
                            'last_name' => $ldapUser->sn[0] ?? 'Unknown',
                            'password' => bcrypt(Str::random(16)),
                        ]
                    );

                    // Log the current type before update
                    Log::info("User email: $email, Previous type: {$localUser->type}");

                    // Explicitly update the "type" after creation or update
                    $localUser->type = $type;
                    $localUser->save();

                    // Log after update
                    Log::info("User email: $email, Updated type: {$localUser->type}");
                }
            }
        }

        // Optionally delete users not in the file
        User::whereNotIn('email', $emailsFromFile)->delete();
    }


}
