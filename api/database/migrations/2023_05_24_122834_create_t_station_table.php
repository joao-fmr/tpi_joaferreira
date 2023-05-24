<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Migration for creating the table t_station
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_station', function (Blueprint $table) {
            // columns of the  table
            $table->string('idStation', 3)->primary(); // primary key
            $table->string('staName', 35);
            $table->string('staImg', 1000)->nullable();
        });

        // Insert the known stations in the Database
        DB::table('t_station')->insert([
            ['idStation' => 'PRE', 'staName' => 'St-Prex', 'staImg' => ''],
            ['idStation' => 'CGI', 'staName' => 'Nyon / Changins', 'staImg' => ''],
            ['idStation' => 'GVE', 'staName' => 'Genève / Cointrin', 'staImg' => '']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_station');
    }
};
