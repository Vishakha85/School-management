<?php
// namespace App\Models;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Teacher extends Model {
//     use HasFactory;
//     protected $fillable = ['name', 'email', 'experience', 'department', 'password', 'image'];
//     protected $primaryKey = 'id';
//     public function students()
//     {
//         return $this->belongsToMany(\App\Models\AddStudent::class, 'student_teacher', 'teacher_id', 'student_id');
//     }
// }
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'experience', 'department', 'password', 'image'];

    protected $primaryKey = 'id';

    /**
     * Many-to-Many relationship with students (AddStudent model)
     */
    public function students()
    {
        return $this->belongsToMany(\App\Models\AddStudent::class, 'student_teacher', 'teacher_id', 'student_id');
    }

    /**
     * Optional: Relationship to assignments if applicable
     */
    public function assignments()
    {
        return $this->hasMany(\App\Models\Assignment::class, 'teacher_id'); // adjust model and foreign key accordingly
    }

}

