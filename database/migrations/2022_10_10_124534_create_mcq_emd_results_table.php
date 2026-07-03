<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqEmdResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_emd_results', function (Blueprint $table) {
            $table->id();
			$table->integer('student_id')->nullable();
			$table->integer('subject_id')->nullable();
			$table->integer('mcq_question_paper_id')->nullable();
			$table->integer('easy_total')->nullable();
			$table->integer('easy_correct')->nullable();
			$table->integer('easy_wrong')->nullable();
			$table->integer('easy_skip')->nullable();
			$table->integer('medium_total')->nullable();
			$table->integer('medium_correct')->nullable();
			$table->integer('medium_wrong')->nullable();
			$table->integer('medium_skip')->nullable();
			$table->integer('difficult_total')->nullable();
			$table->integer('difficult_correct')->nullable();
			$table->integer('difficult_wrong')->nullable();
			$table->integer('difficult_skip')->nullable();
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
        Schema::dropIfExists('mcq_emd_results');
    }
}
