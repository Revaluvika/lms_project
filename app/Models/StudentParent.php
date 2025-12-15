<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'nik',
        'kk_number',
        'occupation',
        'monthly_income',
        'education_level',
        'phone_alternate',
        'address_domicile',
    ];

    protected $casts = [
        'monthly_income' => \App\Enums\MonthlyIncome::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id')
            ->withPivot('relation_type', 'is_guardian')
            ->withTimestamps();
    }
}
