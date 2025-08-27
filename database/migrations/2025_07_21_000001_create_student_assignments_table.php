<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_assignments', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('std_id'); // Student ID from students table
            $table->string('student_name'); // Student name from students table
            $table->unsignedBigInteger('course_id'); // Course ID from fee_structure table
            $table->string('class'); // Class from fee_structure table
            $table->string('assignment'); // Assignment file path
            $table->timestamps();

            $table->foreign('std_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('fee_structures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assignments');
    }
};
