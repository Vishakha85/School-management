<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'class')) {
                $table->unsignedBigInteger('class')->after('id');
                $table->foreign('class')->references('id')->on('classes')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'class')) {
                $table->dropForeign(['class']);
                $table->dropColumn('class');
            }
        });
    }
};
