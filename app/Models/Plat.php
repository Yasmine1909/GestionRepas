<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Plat extends Model
{
    use HasFactory;

    protected $fillable = ['jour_id', 'titre'];

    public function jour()
    {
        return $this->belongsTo(Jour::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
