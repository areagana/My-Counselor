<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('client_id');
            $table->integer('issue_id');
            $table->integer('topic_id')->nullable();
            $table->integer('schedule_id')->nullable();
            $table->string('category_id');
            $table->longText('shared_info')->nullable();
            $table->longText('resolution')->nullable();
            $table->longText('progress')->nullable();
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
        Schema::dropIfExists('records');
    }
}
