<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable()->change();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
    }
};
