<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->string('student_name')->nullable();
            $table->text('changes_summary')->nullable();
            $table->unsignedBigInteger('student_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->dropColumn(['student_name', 'changes_summary', 'student_id']);
        });
    }
};
