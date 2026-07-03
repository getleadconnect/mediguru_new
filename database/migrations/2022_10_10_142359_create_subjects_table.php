<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
			$table->integer('course_id')->nullable();
			$table->integer('course_unique_id')->nullable();
			$table->integer('subject_name',100)->nullable();
			$table->string('subject_type',50)->nullable();
			$table->integer('reorder_no')->nullable();
			$table->string('description',1000)->nullable();
			$table->string('subject_icon',200)->nullable();
			$table->float('question_mark')->nullable();
			$table->float('negative_mark')->nullable();
			$table->date('subscription_end_date')->nullable();
			$table->string('app_store_product_id',100)->nullable();
			$table->tinyinteger('ios_subscription_type')->nullable();
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
        Schema::dropIfExists('subjects');
    }
}
