<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinancialYearIdToContributionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_year_id')->nullable();
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contribution', function (Blueprint $table) {
            //
        });
    }
}
