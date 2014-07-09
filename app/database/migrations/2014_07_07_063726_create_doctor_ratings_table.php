<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctor_ratings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('doctor_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('friendliness')->nullable();
            $table->integer('clarity')->nullable();
            $table->integer('trustworthiness')->nullabe();
            $table->integer('personal_hygiene')->nullable();
            $table->integer('listening')->nullable();
            $table->integer('wait_time')->nullable();
            $table->integer('accessibility')->nullabe();
            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
		Schema::drop('doctor_ratings');
	}

}
