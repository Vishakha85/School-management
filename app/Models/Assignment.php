<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
   public $timestamps = true; 
    protected $table = 'assignments';
protected $fillable = ['assignment_topic', 'assignment_question', 'assignment_description', 'course_id'];
}
