<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('assignment_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_teacher_id');
            $table->integer('marks')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();
            $table->foreign('student_teacher_id')->references('id')->on('student_teacher')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignment_reviews');
    }
};
