<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFeeStatus extends Model
{
    protected $table = 'student_fee_statuses';
    protected $fillable = [
        'student_id', 'class', 'annual_fee', 'tuition_fee', 'total_fee', 'fee_status'
    ];
}
