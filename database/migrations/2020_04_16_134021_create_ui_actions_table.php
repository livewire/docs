<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUiActionsTable extends Migration
{
    public function up()
    {
        Schema::create('ui_actions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('type');
            $table->timestamps();
        });
    }
}
