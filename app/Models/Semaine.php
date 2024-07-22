<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semaine extends Model
{
    protected $fillable = ['date_debut'];

    public function jours()
    {
        return $this->hasMany(Jour::class);
    }
}
