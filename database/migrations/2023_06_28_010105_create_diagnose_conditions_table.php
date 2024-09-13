<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnose_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnose_id')->references('id')->on('diagnoses')->cascadeOnDelete();
            $table->unsignedInteger('compulsory_cases')->nullable()->default(0);
            $table->enum('type',['main','or','and'])->default('main');
            $table->boolean('check_o2_saturation')->default(0);
            $table->float('o2_saturation_difference_value')->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnose_conditions');
    }
};
