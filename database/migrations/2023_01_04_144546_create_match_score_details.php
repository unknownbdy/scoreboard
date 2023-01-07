<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchScoreDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_score_details', function (Blueprint $table) {

            $table->id('id');
            $table->string('match_id',50);
            $table->string('time_duration',50)->default(0);
            $table->string('team_first',50);
            $table->integer('team_first_score')->default(0);
            $table->string('team_second',50);
            $table->integer('team_second_score')->default(0);
            $table->enum('team_first_win',["WON","LOST","DRAW"]);
            $table->enum('team_second_win',["WON","LOST","DRAW"]);
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
        Schema::dropIfExists('match_score_details');
    }
}
