<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'std_id',
        'name',
        'branch',
        'passoutyear',
        // 'feestatus',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id');
    }
}
