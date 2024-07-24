<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveDaysConfiguration extends Model
{
    use HasFactory;

    protected $table = 'active_days_configuration';

    protected $fillable = ['active_days'];

    protected $casts = [
        'active_days' => 'array',
    ];
}
