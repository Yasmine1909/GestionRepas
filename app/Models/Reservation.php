<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jour_id', 'status', 'reason'];

    public function jour()
    {
        return $this->belongsTo(Jour::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
