<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreencastProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screencast_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('screencast_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('last_known_timestamp_in_seconds')->default(0);
            $table->dateTime('completed_at')->nullable();
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
        Schema::dropIfExists('screencast_progress');
    }
}
