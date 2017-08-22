<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuizResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_results', function (Blueprint $table) {
            $table->string('player_user_unique' , 26)->nullable()->change();
            $table->dropColumn('created_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_results', function (Blueprint $table) {
            $table->string('player_user_unique' , 26)->change();
            $table->string('created_user_unique' , 26);
        });
    }
}
