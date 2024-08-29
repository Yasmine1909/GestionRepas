<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jour extends Model
{
    use HasFactory;

    protected $fillable = ['semaine_id', 'date', 'jour']; // Assurez-vous que 'date' est inclus
    protected $dates = ['date'];
    public function semaine()
    {
        return $this->belongsTo(Semaine::class);
    }
    public function plats()
    {
        return $this->hasMany(Plat::class);
    }

}
