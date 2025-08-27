<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            if (!Schema::hasColumn('assignments', 'course_id')) {
                $table->unsignedBigInteger('course_id')->after('id');
                $table->foreign('course_id')->references('id')->on('classes')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            if (Schema::hasColumn('assignments', 'course_id')) {
                $table->dropForeign(['course_id']);
                $table->dropColumn('course_id');
            }
        });
    }
};
