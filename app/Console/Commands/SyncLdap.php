<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LdapService;

class SyncLdap extends Command
{
    protected $signature = 'ldap:sync';
    protected $description = 'Synchronize the database with LDAP';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $ldapService = new LdapService();

        $ldapService->sync();

        $this->info('Database synchronized with LDAP successfully.');
    }
}
