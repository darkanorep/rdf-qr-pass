<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'group_id',
        'created_at'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AttendeeAnswers::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(AttendeeResponses::class);
    }

    public function supplier_guests(): HasManyThrough {
        return $this->hasManyThrough(SupplierGuest::class, AttendeeResponses::class, 'attendee_id', 'attendee_response_id', 'id', 'id');
    }
}
