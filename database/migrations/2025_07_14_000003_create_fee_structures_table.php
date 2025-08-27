<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->string('class')->primary();
            $table->integer('annual_fee');
            $table->integer('per_sem_fee');
            $table->integer('tuition_fee');
            $table->integer('total_fee');
            $table->string('fee_status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
