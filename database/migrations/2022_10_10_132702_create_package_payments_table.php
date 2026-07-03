<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_payments', function (Blueprint $table) {
            $table->id();
			$table->integer('student_id')->nullable();
			$table->integer('course_unique_id')->nullable();
			$table->string('package_id',50)->nullable();
			$table->string('payment_id',100)->nullable();
			$table->string('promocode',50)->nullable();
			$table->integer('promocode_value')->nullable();
			$table->string('refferal_code',50)->nullable();
			$table->integer('refferal_value')->nullable();
			$table->integer('package_rate')->nullable();
			$table->integer('net_amount')->nullable();
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
        Schema::dropIfExists('package_payments');
    }
}
