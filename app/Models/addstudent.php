<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddStudent extends Model
{
    public $timestamps = false;
    protected $table = 'students';
    protected $fillable = ['name', 'email', 'class', 'number', 'age', 'password'];

    public function teachers()
    {
        return $this->belongsToMany(\App\Models\Teacher::class, 'student_teacher', 'student_id', 'teacher_id');
    }
}
