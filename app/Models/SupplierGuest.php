<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendee_response_id',
        'first_name',
        'last_name',
        'company'
    ];
}
