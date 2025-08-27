<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('department')->change();
            $table->foreign('department')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['department']);
        });
    }
};
