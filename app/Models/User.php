<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Le nom de la clé primaire.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Les types de cast des attributs.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string', // Assurez-vous que l'ID est traité comme une chaîne
        'email_verified_at' => 'datetime',
    ];

    /**
     * Indique si les IDs sont auto-incrémentés.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
