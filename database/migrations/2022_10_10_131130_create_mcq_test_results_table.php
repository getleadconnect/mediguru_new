<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_test_results', function (Blueprint $table) {
            $table->id();
			$table->integer('subject_id')->nullable();
			$table->integer('mcq_question_paper_id')->nullable();
			$table->integer('student_id')->nullable();
			$table->date('test_date')->nullable();
			$table->integer('total_questions')->default(0);
			$table->integer('answer')->nullable();
			$table->integer('wrong')->nullable();
			$table->integer('skipped')->nullable();
			$table->string('marks',10)->nullable();
			$table->double('negative')->nullable();
			$table->double('score')->nullable();
			$table->integer('total_time')->nullable();
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
        Schema::dropIfExists('mcq_test_results');
    }
}
