<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTeacher extends Model
{
    protected $table = 'student_teacher'; // Adjust if your table name is different
    protected $fillable = ['student_id', 'teacher_id'];
    public $timestamps = false;
}
