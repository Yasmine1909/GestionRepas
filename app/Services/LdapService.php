<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use LdapRecord\Laravel\LdapServiceProvider;

class LdapService
{
    public function sync()
    {

        $ldapUsers = $this->getLdapUsers();


        foreach ($ldapUsers as $user) {

            DB::table('users')->updateOrInsert(
                ['ldap_id' => $user->id],
                ['name' => $user->name, 'email' => $user->email]
            );
        }
    }

    private function getLdapUsers()
    {

        return [];
    }
}
