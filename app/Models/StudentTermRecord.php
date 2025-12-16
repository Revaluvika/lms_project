<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTermRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'classroom_id',
        'sick_count',
        'permission_count',
        'absentee_count',
        'notes',
        'promotion_status',
    ];

    protected $casts = [
        'promotion_status' => \App\Enums\PromotionStatus::class,
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function extracurriculars()
    {
        return $this->hasMany(ExtracurricularRecord::class, 'student_term_record_id');
    }
}
