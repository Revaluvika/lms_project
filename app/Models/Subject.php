<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'code',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
