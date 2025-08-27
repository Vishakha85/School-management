<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'student_id',
        // 'name', // course name
        // 'class', // class id or reference, not the name
        'core_subject',
        'duration',
        'payment',
        'approved',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
