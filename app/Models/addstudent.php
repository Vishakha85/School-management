<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addstudent extends Model
{
 
     public $timestamps = false; 
    protected $table = 'students';
    protected $fillable = ['name', 'class', 'number', 'age','password','status'];
}
