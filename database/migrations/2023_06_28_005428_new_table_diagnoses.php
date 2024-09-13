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
        Schema::disableForeignKeyConstraints();
        Schema::drop('diagnoses');
        Schema::create('diagnoses',function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('diagnoses');
        Schema::create('diagnoses',function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->unsignedInteger('compulsory_symptoms')->default(0);
            $table->unsignedInteger('compulsory_criteria')->default(0);
            $table->json('symptom_ids')->default('[]')->nullable();
            $table->json('criteria_ids')->default('[]')->nullable();
            $table->json('must_include_symptom_ids')->default('[]')->nullable();
            $table->json('must_include_criteria_ids')->default('[]')->nullable();
            $table->foreignId('last_criteria_if_all_fails')->nullable()->references('id')->on('diagnose_criterias')->cascadeOnDelete();
            $table->boolean('check_current_saturation')->default(0);
            $table->float('saturation_difference_value')->nullable();
        });
        Schema::enableForeignKeyConstraints();
    }
};
