<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_questions', function (Blueprint $table) {
            $table->id();
			$table->integer('mcq_question_paper_id')->nullable();
			$table->tinyinteger('question_mode')->nullable();
			$table->tinyinteger('question_type')->nullable();
			$table->string('question',300)->nullable();
			$table->string('question_image',200)->nullable();
			$table->string('answer_1',500)->nullable();
			$table->string('answer_2',500)->nullable();
			$table->string('answer_3',500)->nullable();
			$table->string('answer_4',500)->nullable();
			$table->integer('correct_answer')->nullable();
			$table->text('explanation')->nullable();
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
        Schema::dropIfExists('mcq_questions');
    }
}
