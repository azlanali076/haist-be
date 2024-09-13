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
        Schema::create('diagnose_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnose_id')->references('id')->on('diagnoses')->cascadeOnDelete();
            $table->foreignId('diagnose_condition_id')->references('id')->on('diagnose_conditions')->cascadeOnDelete();
            $table->morphs('case');
            $table->boolean('must_include')->default(0);
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
        Schema::dropIfExists('diagnose_cases');
    }
};
