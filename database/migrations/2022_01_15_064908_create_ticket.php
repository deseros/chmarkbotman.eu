<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('provider_id')->unsigned()->index();
            $table->integer('bx_ticket_id')->nullable();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->biginteger('assigned_to')->nullable()->unsigned()->index();
            $table->foreign('provider_id')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('tickets');
    }
}
