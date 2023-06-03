<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statistics_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('value');
            $table->dateTime('period_date');
            $table->enum('period', ['whole', 'month', 'week']);
            $table->unsignedBigInteger('entity_id');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics_views');
    }
};
