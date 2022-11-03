<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RepliesMedias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_models', function (Blueprint $table) {
            $table->bigInteger('file_id')->unsigned()->index();
            $table->foreign('file_id')->references('id')->on('file_entries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->morphs('files_model');
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
        Schema::dropIfExists('replies_medias');
    }
}
