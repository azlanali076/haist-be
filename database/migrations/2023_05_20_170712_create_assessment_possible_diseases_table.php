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
        Schema::create('assessment_possible_diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->references('id')->on('assessments')->cascadeOnDelete();
            $table->foreignId('disease_id')->references('id')->on('diagnoses')->cascadeOnDelete();
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
        Schema::dropIfExists('assessment_possible_diseases');
    }
};
