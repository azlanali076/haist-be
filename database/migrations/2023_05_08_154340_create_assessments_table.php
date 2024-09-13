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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->references('id')->on('facilities')->cascadeOnDelete();
            $table->foreignId('patient_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('heart_rate')->nullable();
            $table->string('temperature')->nullable();
            $table->string('o2_saturation')->nullable();
            $table->string('base_o2_saturation')->nullable();
            $table->string('respiratory_rate')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('assessments');
    }
};
