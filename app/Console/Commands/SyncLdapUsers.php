<?php

 namespace App\Console\Commands;

 use Illuminate\Console\Command;
 use App\Models\User;
 use Illuminate\Support\Str;
 use LdapRecord\Models\ActiveDirectory\User as LdapUser;

// class SyncLdapUsers extends Command
// {
//     protected $signature = 'ldap:sync-users';
//     protected $description = 'Synchronize LDAP users to the local database';

//     public function handle()
//     {
//         $ldapUsers = LdapUser::get();

//         foreach ($ldapUsers as $ldapUser) {
//             // Log LDAP user details for debugging
//             $this->info('Processing LDAP user: ' . $ldapUser->distinguishedName);

//             $email = $ldapUser->mail[0] ?? null;
//             $firstName = $ldapUser->cn[0] ?? 'Unknown';
//             $lastName = $ldapUser->sn[0] ?? 'Unknown';

//             // Print LDAP user attributes for debugging
//             $this->info('Email: ' . $email);
//             $this->info('First Name: ' . $firstName);
//             $this->info('Last Name: ' . $lastName);

//             if ($email) {
//                 $user = User::firstOrNew(['email' => $email]);
//                 if (!$user->exists) {
//                     $user->id = (string) Str::uuid(); // Assign UUID if user does not exist
//                 }
//                 $user->name = $firstName;
//                 $user->last_name = $lastName;
//                 $user->email = $email;
//                 $user->password = bcrypt(Str::random(16)); // Default random password
//                 $user->save();
//                 $this->info('User synchronized: ' . $email);
//             } else {
//                 $this->error('LDAP user without email address ignored: ' . $ldapUser->distinguishedName);
//             }
//         }

//         $this->info('LDAP users have been synchronized successfully.');
//     }

// }
class SyncLdapUsers extends Command
{
    protected $signature = 'ldap:sync-users';
    protected $description = 'Synchronize LDAP users to the local database';

    public function handle()
    {
        $ldapUsers = LdapUser::get();

        foreach ($ldapUsers as $ldapUser) {
            $email = $ldapUser->mail[0] ?? null;
            $firstName = $ldapUser->cn[0] ?? 'Unknown';
            $lastName = $ldapUser->sn[0] ?? 'Unknown';
            $objectGuid = $ldapUser->getConvertedGuid(); // Utilise la méthode existante

            if ($email && $objectGuid) {
                // Utiliser updateOrCreate pour créer ou mettre à jour l'utilisateur
                $user = User::updateOrCreate(
                    ['email' => $email], // Critères de correspondance
                    [
                        'id' => $objectGuid, // Utiliser l'ID LDAP comme clé primaire
                        'name' => $firstName,
                        'last_name' => $lastName,
                        'password' => bcrypt(Str::random(16)), // Mot de passe par défaut
                    ]
                );

                $this->info('User synchronized: ' . $email);
            } else {
                $distinguishedName = is_array($ldapUser->distinguishedName) ? implode(', ', $ldapUser->distinguishedName) : (string) $ldapUser->distinguishedName;
                $this->error('LDAP user without email or GUID ignored: ' . $distinguishedName);
            }
        }

        $this->info('LDAP users have been synchronized successfully.');
    }
}
