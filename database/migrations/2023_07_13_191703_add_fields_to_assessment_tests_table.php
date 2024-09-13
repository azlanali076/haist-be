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
        Schema::table('assessment_tests', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('status');
            $table->string('file')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_tests', function (Blueprint $table) {
            $table->dropColumn(['notes','file']);
        });
    }
};
