<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeeResponses extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'attendee_id',
        'is_additional'
    ];
}
