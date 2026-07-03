<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
			$table->integer('course_unique_id')->nullable();
			$table->string('subject_id',100)->nullable();
			$table->string('package_name',100)->nullable();
			$table->tinyinteger('package_type')->nullable();
			$table->date('start_date')->nullable();
			$table->date('expiry_date')->nullable();
			$table->integer('rate')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
