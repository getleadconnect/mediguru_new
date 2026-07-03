<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLatestNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('latest_news', function (Blueprint $table) {
            $table->id();
			$table->date('added_date')->nullable();
			$table->integer('course_id')->nullable();
			$table->integer('subject_id')->nullable();
			$table->integer('news_type')->nullable();
			$table->integer('display_order')->nullable();
            $table->string('class_link',100)->nullable();
			$table->date('class_date')->nullable();
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->string('news_icon',200)->nullable();
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
        Schema::dropIfExists('latest_news');
    }
}
