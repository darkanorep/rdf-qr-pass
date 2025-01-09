<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'attendance';

    protected $fillable = [
        'attendee_id',
        'is_present',
        'is_eligible',
    ];
}
