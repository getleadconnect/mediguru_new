<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
			$table->string('staff_name',100)->nullable();
			$table->string('gender',20)->nullable();
			$table->string('email',100)->nullable();
			$table->string('mobile',100)->nullable();
			$table->string('referral_code',100)->nullable();
			$table->integer('referral_value')->nullable();
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
        Schema::dropIfExists('staffs');
    }
}
