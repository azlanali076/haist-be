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
        Schema::create('diagnose_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('criteria_key',['heart_rate','temperature','o2_saturation','base_o2_saturation','respiratory_rate','blood_pressure'])->nullable();
            $table->enum('criteria_comparison_operator',['gt','lt','eq','gte','lte'])->nullable();
            $table->float('criteria_value')->nullable();
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
        Schema::dropIfExists('diagnose_criterias');
    }
};
