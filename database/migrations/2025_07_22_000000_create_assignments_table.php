<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('assignment_topic');
            $table->text('assignment_question');
            $table->timestamps();
            $table->foreign('course_id')->references('course_id')->on('fee_structures')->onDelete('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('assignments');
    }
};
