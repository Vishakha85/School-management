<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentReview extends Model
{
    protected $table = 'assignment_reviews';
    protected $fillable = ['student_teacher_id', 'marks', 'summary'];
}
