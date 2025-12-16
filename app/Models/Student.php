<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Enums\StudentStatus;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'school_id',
        'classroom_id',
        'nama',
        'nis',
        'alamat',
        'telepon',
        'status',
    ];

    protected $casts = [
        'status' => StudentStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function parents()
    {
        return $this->belongsToMany(StudentParent::class, 'parent_student', 'student_id', 'parent_id')
            ->withPivot('relation_type', 'is_guardian')
            ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class);
    }
}
