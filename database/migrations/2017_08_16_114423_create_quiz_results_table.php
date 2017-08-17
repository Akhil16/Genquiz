<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('play_unique' , 26);
            $table->string('quiz_unique' , 20);
            $table->string('player_user_unique' , 26);
            $table->string('created_user_unique' , 26);
            $table->tinyInteger('completed_question');
            $table->float('score' , 5 , 2)->default(0.00);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('quiz_results');
    }
}
