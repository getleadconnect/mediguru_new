<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_comments', function (Blueprint $table) {
            $table->id();
			$table->integer('student_id')->nullable();
			$table->integer('video_unique_id')->nullable();
			$table->integer('material_type')->nullable();
			$table->text('comments')->nullable();
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
        Schema::dropIfExists('material_comments');
    }
}
