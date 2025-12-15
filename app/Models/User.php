<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'school_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => UserRole::class,
        'email_verified_at' => 'datetime',
    ];

    public function anak()
    {
        return $this->hasMany(User::class, 'school_id');
    }

    public function orangTua()
    {
        // Legacy or unused? Keeping for safety if used elsewhere, potentially deprecated.
        return $this->belongsTo(User::class, 'school_id'); // suspicious relation
    }

    public function studentParent()
    {
        return $this->hasOne(StudentParent::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}


