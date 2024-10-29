<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Limit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "group_id",
        "limit",
        "year",
    ];

    protected $hidden = [
        'created_at'
    ];
}
