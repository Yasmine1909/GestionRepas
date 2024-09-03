<?php

 namespace App\Console\Commands;

 use Illuminate\Console\Command;
 use App\Models\User;
 use Illuminate\Support\Str;
 use LdapRecord\Models\ActiveDirectory\User as LdapUser;
 use Illuminate\Support\Facades\Notification;
 use App\Notifications\LdapSyncNotification;

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
            $objectGuid = $ldapUser->getConvertedGuid();

            if ($email && $objectGuid) {

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'id' => $objectGuid,
                        'name' => $firstName,
                        'last_name' => $lastName,
                        'password' => bcrypt(Str::random(16)),
                    ]
                );

                $this->info('User synchronized: ' . $email);
            } else {
                $distinguishedName = is_array($ldapUser->distinguishedName) ? implode(', ', $ldapUser->distinguishedName) : (string) $ldapUser->distinguishedName;
                $this->error('LDAP user without email or GUID ignored: ' . $distinguishedName);
            }
        }

        $this->info('LDAP users have been synchronized successfully.');
        $user = User::first();
        Notification::route('mail', 'yasminektb@outlook.com')
            ->notify(new LdapSyncNotification());
    }
}
