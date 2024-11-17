<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'color_id'
    ];

    protected $hidden = [
        'created_at'
    ];

    public function color() : belongsTo
    {
        return $this->belongsTo(Color::class)->withTrashed();
    }
}
