<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GameKey', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("ownerid");
            $table->string("gamename");
            $table->string("key");
            $table->bigInteger("winnerid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('GameKey');
    }
}
