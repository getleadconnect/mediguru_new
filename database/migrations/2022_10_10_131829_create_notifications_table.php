<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
			$table->date('added_date')->nullable();
			$table->integer('course_unique_id')->nullable();
			$table->integer('subject_id')->nullable();
			$table->string('title',100)->nullable();
			$table->text('message')->nullable();
			$table->text('message_type')->nullable()->comment('1-general,2-subject,3-course');
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
        Schema::dropIfExists('notifications');
    }
}
