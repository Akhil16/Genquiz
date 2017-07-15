<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users' , function(Blueprint $table){

            $table->tinyInteger('social_auth')->nullable();
            $table->string('social_auth_id' , 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users' , function(Blueprint $table){

            $table->dropColumn('social_auth');
            $table->dropColumn('social_auth_id');
        });
    }
}
