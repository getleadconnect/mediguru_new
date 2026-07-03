<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqTestAllResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_test_all_results', function (Blueprint $table) {
            $table->id();
			$table->date('result_date')->nullable();
			$table->integer('subject_id')->nullable();
			$table->integer('mcq_question_paper_id')->nullable();
			$table->integer('student_id')->nullable();
			$table->integer('question_id')->nullable();
			$table->tinyinteger('question_mode')->nullable();
			$table->tinyinteger('question_type')->nullable();
			$table->integer('correct_answer')->nullable();
			$table->tinyinteger('answer')->nullable();
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
        Schema::dropIfExists('mcq_test_all_results');
    }
}
