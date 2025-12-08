<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'start_date',
        'end_date',
        'type',
        'description',
        'is_holiday',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_holiday' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
