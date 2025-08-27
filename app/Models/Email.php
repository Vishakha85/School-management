<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'subject', 'body', 'recipient', 'student_name', 'changes_summary', 'student_id'
    ];

    public function student()
    {
        return $this->belongsTo(\App\Models\student::class, 'student_id');
    }
}
