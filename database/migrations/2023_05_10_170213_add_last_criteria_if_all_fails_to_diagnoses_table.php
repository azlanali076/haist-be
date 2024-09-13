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
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->foreignId('last_criteria_if_all_fails')->nullable()->references('id')->on('diagnose_criterias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn('last_criteria_if_all_fails');
            Schema::enableForeignKeyConstraints();
        });
    }
};
