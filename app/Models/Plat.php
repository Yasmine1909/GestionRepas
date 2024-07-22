<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plat extends Model
{
    protected $fillable = ['jour_id', 'titre'];
    public function jour()
    {
        return $this->belongsTo(Jour::class, 'jour_id');
    }
}
