<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqQuestionPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_question_papers', function (Blueprint $table) {
            $table->id();
			$table->integer('course_id')->nullable();
			$table->integer('unique_id')->nullable();
			$table->integer('question_paper_type')->nullable();
			$table->string('question_paper_name',100)->nullable();
			$table->tinyinteger('premium')->nullable();
			$table->text('instruction')->nullable();
			$table->integer('test_time')->nullable();
			$table->date('test_date')->nullable();
			$table->time('start_time')->nullable();
			$table->string('start_time_text',50)->nullable();
			$table->date('schedule_date')->nullable();
			$table->string('question_paper_icon',200)->nullable();
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
        Schema::dropIfExists('mcq_question_papers');
    }
	
}
