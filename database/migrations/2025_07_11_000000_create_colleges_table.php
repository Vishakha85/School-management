<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('std_id');
            $table->string('name');
            $table->string('branch');
            $table->year('passoutyear');
            // $table->string('feestatus');
            $table->timestamps();

            $table->foreign('std_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
