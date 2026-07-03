<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
			$table->integer('qb_subject_id')->nullable();
			$table->integer('question_type')->nullable();
			$table->integer('question_mode')->nullable();
			$table->string('question',500)->nullable();
			$table->string('question_image',200)->nullable();
			$table->string('answer_1',500)->nullable();
			$table->string('answer_2',500)->nullable();
			$table->string('answer_3',500)->nullable();
			$table->string('answer_4',500)->nullable();
			$table->integer('correct_answer')->nullable();
			$table->text('explanation')->nullable();
			$table->tinyinteger('status')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
