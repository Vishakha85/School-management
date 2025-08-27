<?php
// Run this seeder after migration to populate student_fee_statuses from students and fee_structures
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\student;
use App\Models\FeeStructure;

class StudentFeeStatusSeeder extends Seeder
{
    public function run()
    {
        $students = student::all();
        foreach ($students as $student) {
            $fee = FeeStructure::where('course_id', $student->class)->first();
            DB::table('student_fee_statuses')->insert([
                'student_id' => $student->id,
                'class' => $student->class,
                'annual_fee' => $fee->annual_fee ?? 0,
                'tuition_fee' => $fee->tuition_fee ?? 0,
                'total_fee' => $fee->total_fee ?? 0,
                'fee_status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
