<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jour extends Model
{
    protected $fillable = ['semaine_id', 'jour'];

    public function plats()
    {
        return $this->hasMany(Plat::class);
    }
}
