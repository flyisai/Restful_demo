<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctor_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('doctor_id')->unsigned();
			$table->timestamps();
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('doctor_id')
				->references('id')
				->on('doctors')
				->onDelete('cascade');				
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('doctor_user');
	}

}
