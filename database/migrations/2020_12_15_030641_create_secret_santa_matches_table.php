<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecretSantaMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SecretSantaMatch', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("senderid");
            $table->bigInteger("receiverid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SecretSantaMatch');
    }
}
