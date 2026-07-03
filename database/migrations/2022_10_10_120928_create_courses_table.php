<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
			$table->integer('unique_id')->unique();
			$table->string('course_name',100)->nullable();
			$table->integer('course_type')->nullable();
            $table->string('description',500)->nullable();
			$table->text('features')->nullable();
			$table->string('course_icon',200)->nullable();
			$table->double('question_mark')->nullable();
			$table->double('negative_mark')->nullable();
			$table->date('subscription_end_date')->nullable();
			$table->string('app_store_product_id',100)->nullable();
			$table->tinyinteger('ios_subscription_type')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
