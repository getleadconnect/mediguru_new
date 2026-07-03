<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_packages', function (Blueprint $table) {
            $table->id();
			$table->integer('course_unique_id')->nullable();
			$table->integer('student_id')->nullable();
			$table->integer('package_id')->nullable();
			$table->string('promocode',50)->nullable();
			$table->double('promocode_amount')->nullable();
			$table->string('referral_code',100)->nullable();
			$table->double('referral_amount')->nullable();
			$table->double('amount')->nullable();
			$table->double('net_amount')->nullable();
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
        Schema::dropIfExists('purchased_packages');
    }
}
