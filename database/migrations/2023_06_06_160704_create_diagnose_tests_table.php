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
        Schema::create('diagnose_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnose_id')->references('id')->on('diagnoses')->cascadeOnDelete();
            $table->foreignId('test_id')->references('id')->on('disease_tests')->cascadeOnDelete();
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
        Schema::dropIfExists('diagnose_tests');
    }
};
