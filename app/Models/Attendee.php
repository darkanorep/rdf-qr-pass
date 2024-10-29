<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendee extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'group_id',
        'first_name',
        'last_name',
        'contact',
        'company',
        'employee_id',
        'position',
        'department',
        'unit',
    ];

    protected $hidden = [
        'created_at'
    ];
}
