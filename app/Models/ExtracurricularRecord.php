<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_term_record_id',
        'activity_name',
        'grade',
        'description',
    ];

    public function termRecord()
    {
        return $this->belongsTo(StudentTermRecord::class, 'student_term_record_id');
    }
}
