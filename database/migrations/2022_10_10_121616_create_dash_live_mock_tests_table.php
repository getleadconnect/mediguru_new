<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashLiveMockTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dash_live_mock_tests', function (Blueprint $table) {
            $table->id();
			$table->date('added_date');
			$table->integer('course_id')->nullable();
            $table->integer('subject_id')->nullable();
			$table->integer('live_unique_id')->nullable();
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
        Schema::dropIfExists('dash_live_mock_tests');
    }
}
