<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_datas', function (Blueprint $table) {
            $table->id();
			$table->integer('student_id')->nullable();
			$table->integer('admin_id')->nullable();
            $table->text('message')->nullable();
			$table->string('pictures',200)->nullable();
			$table->tinyinteger('user_type')->nullable();
			$table->tinyinteger('status')->default('0');
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
        Schema::dropIfExists('chat_datas');
    }
}
