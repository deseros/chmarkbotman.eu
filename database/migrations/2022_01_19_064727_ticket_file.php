<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TicketFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_entries', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('bx_id_file')->nullable();
            $table->string('original_name');
            $table->string('file_name');
            $table->integer('file_size');
            $table->string('file_path');
            $table->text('mime');
            $table->tinyText('extension');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('ticket_medias');
    }
}
