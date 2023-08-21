<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContributionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained()->nullable(); // Defines relations between tables by ID
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->decimal('amount', 10, 2)->default(100); // Default amount for a contribution
            $table->decimal('discount')->nullable();
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
        //
    }
}
