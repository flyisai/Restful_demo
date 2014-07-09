<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUniqueToDoctorRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('doctor_ratings', function(Blueprint $table)
		{
			$table->unique(array('user_id', 'doctor_id'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('doctor_ratings', function(Blueprint $table)
		{
			$table->dropUnique(array('user_id', 'doctor_id'));
		});
	}

}
