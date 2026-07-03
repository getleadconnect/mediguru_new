<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_likes', function (Blueprint $table) {
            $table->id();
			$table->integer('stduent_id')->nullable();
			$table->integer('video_unique_id')->nullable();
			$table->string('material_title',150)->nullable();
			$table->integer('material_type')->nullable();
			$table->tinyinteger('like')->nullable();
			$table->tinyinteger('dislike')->nullable();
			$table->tinyinteger('status');
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
        Schema::dropIfExists('material_likes');
    }
}
