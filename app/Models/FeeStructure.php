<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $table = 'fee_structures';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'course_id', 'annual_fee', 'per_sem_fee', 'tuition_fee', 'total_fee'
    ];

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id');
    }
}
