<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('assignment_reviews', function (Blueprint $table) {
        $table->unsignedBigInteger('assignment_id')->after('student_teacher_id')->nullable();
        $table->foreign('assignment_id')
            ->references('assignment_id')->on('student_assignments')
            ->onDelete('cascade');
    });
}
public function down()
{
    Schema::table('assignment_reviews', function (Blueprint $table) {
        $table->dropForeign(['assignment_id']);
        $table->dropColumn('assignment_id');
    });
}
};
