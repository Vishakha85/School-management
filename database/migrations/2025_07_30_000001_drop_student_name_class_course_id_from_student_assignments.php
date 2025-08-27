<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_assignments', function (Blueprint $table) {
            $table->dropColumn(['student_name', 'class', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_assignments', function (Blueprint $table) {
            $table->string('student_name')->nullable();
            $table->string('class')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
        });
    }
};
