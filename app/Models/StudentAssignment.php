<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    use HasFactory;

    protected $table = 'student_assignments';

    protected $fillable = [
        'std_id',
        'assignment_id',
        'assignment',
    ];
}
