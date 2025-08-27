<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('annual_fee');
            $table->integer('per_sem_fee');
            $table->integer('tuition_fee');
            $table->integer('total_fee');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('classes')->onDelete('cascade');
        });

        // Insert static values for each course_id (must match the IDs in the classes table)
        $courses = [
            'B.Tech' => ['annual_fee' => 120000, 'per_sem_fee' => 20000, 'tuition_fee' => 30000, 'total_fee' => 150000],
            'M.Tech' => ['annual_fee' => 100000, 'per_sem_fee' => 16667, 'tuition_fee' => 25000, 'total_fee' => 125000],
            'MCA' => ['annual_fee' => 90000, 'per_sem_fee' => 15000, 'tuition_fee' => 20000, 'total_fee' => 110000],
            'BCA' => ['annual_fee' => 80000, 'per_sem_fee' => 13333, 'tuition_fee' => 15000, 'total_fee' => 95000],
            'BCOM' => ['annual_fee' => 70000, 'per_sem_fee' => 11667, 'tuition_fee' => 12000, 'total_fee' => 82000],
            'PHD' => ['annual_fee' => 60000, 'per_sem_fee' => 10000, 'tuition_fee' => 10000, 'total_fee' => 70000],
        ];
        foreach ($courses as $className => $feeData) {
            $courseId = DB::table('classes')->where('class', $className)->value('id');
            if ($courseId) {
                DB::table('fee_structures')->insert([
                    'course_id' => $courseId,
                    'annual_fee' => $feeData['annual_fee'],
                    'per_sem_fee' => $feeData['per_sem_fee'],
                    'tuition_fee' => $feeData['tuition_fee'],
                    'total_fee' => $feeData['total_fee'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('fee_structures');
    }
};
