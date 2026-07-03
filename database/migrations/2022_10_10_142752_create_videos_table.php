<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
			$table->integer('unique_id')->nullable();
			$table->string('vimeo_id',100)->nullable();
			$table->integer('premium')->nullable();
			$table->string('icon',100)->nullable();
			$table->string('video_icon',200)->nullable();
			$table->string('video_file',200)->nullable();
			$table->string('title',100)->nullable();
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
        Schema::dropIfExists('videos');
    }
}
