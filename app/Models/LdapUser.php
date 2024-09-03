<?php



namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use LdapRecord\Models\Model;

class LdapUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $guidKey = 'objectguid'; 



}
