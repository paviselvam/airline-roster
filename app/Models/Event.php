<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'flight_number',
        'start_location',
        'end_location',
        'start_time',
        'end_time',
    ];
}
