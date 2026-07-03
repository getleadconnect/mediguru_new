<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_materials', function (Blueprint $table) {
            $table->id();
			$table->integer('lesson_id')->nullable();
			$table->integer('subject_id')->nullable();
			$table->integer('material_unique_id')->nullable();
			$table->integer('order_no')->nullable();
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
        Schema::dropIfExists('lesson_materials');
    }
}
