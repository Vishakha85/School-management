<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Spatie\Permission\Traits\HasRoles;

class Student extends Authenticatable
{ use HasRoles;
    public $timestamps = false;
    protected $table = 'students';
    protected $fillable = ['name', 'email', 'class', 'number', 'age', 'password', 'image'];
    
    public function colleges()
    {
        return $this->hasMany(College::class, 'std_id');
    }
    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class, 'student_id');
    }
    public function teachers()
    {
        return $this->belongsToMany(\App\Models\Teacher::class, 'student_teacher', 'student_id', 'teacher_id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'email', 'email');
}

}