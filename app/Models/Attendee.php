<?php

namespace App\Models;

use App\Filters\AttendeeFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class Attendee extends Model
{
    use HasFactory, softDeletes, Filterable;


    protected string $default_filters = AttendeeFilters::class;

    protected $fillable = [
        'group_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'contact',
        'company',
        'employee_id',
        'position',
        'department',
        'unit',
        'subunit',
        'category',
        'building_id',
        'qr_code',
        'attendee_number',
    ];

    protected $hidden = [
        'group_id',
        'building_id',
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

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendeesAttendance() {
        return $this->has('attendance')->select('id', 'employee_id', 'first_name', 'last_name', 'suffix');
    }

//    public function responses(): HasMany
//    {
//        return $this->hasMany(AttendeeResponses::class);
//    }
//
//    public function supplier_guests(): HasManyThrough {
//        return $this->hasManyThrough(SupplierGuest::class, AttendeeResponses::class, 'attendee_id', 'attendee_response_id', 'id', 'id');
//    }

    public function getWinners() : Collection{
        return $this->whereHas('attendance', fn ($query) => $query->onlyTrashed())->get();
    }
}
