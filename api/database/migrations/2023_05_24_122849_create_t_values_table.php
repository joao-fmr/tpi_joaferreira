<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Migration for creating the table t_values
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_values', function (Blueprint $table) {
            // columns of the table
            $table->increments('idValues'); // primary key
            $table->float('valWindSpeed');
            $table->float('valWindDirection');
            $table->float('valGust');
            $table->dateTime('valEntryDate');
            $table->dateTime('valRegisteredDate');
            $table->string('fkStation', 3); // foreign key
            
            $table->foreign('fkStation')->references('idStation')->on('t_station'); // reference to foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_values');
    }
};
