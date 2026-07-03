<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_devices', function (Blueprint $table) {
            $table->id();
			$table->date('reg_date')->nullable();
			$table->integer('student_id')->nullable();
			$table->string('student_name',100)->nullable();
			$table->string('mobile',100)->nullable();
			$table->string('version_release',100)->nullable();
			$table->string('manufacturer',100)->nullable();
			$table->string('model',100)->nullable();
			$table->string('androidid',100)->nullable();
			$table->string('brand',100)->nullable();
			$table->string('device',100)->nullable();
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
        Schema::dropIfExists('student_devices');
    }
}
