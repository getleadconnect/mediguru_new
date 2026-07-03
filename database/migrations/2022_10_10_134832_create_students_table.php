<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
			$table->integer('name',100)->nullable();
			$table->integer('gender',50)->nullable();
			$table->date('date_of_birth')->nullable();
			$table->string('mobile',100)->unique()->nullable();
			$table->string('email',100)->unique()->nullable();
			$table->string('state',100)->nullable();
			$table->integer('package_status')->default(0);
			$table->string('student_image',200)->nullable();
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
        Schema::dropIfExists('students');
    }
}
