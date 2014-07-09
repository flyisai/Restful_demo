<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCustomColumnsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('full_name')->nullable();			
			$table->string('gender')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->string('street_address')->nullable();
			$table->string('city')->nullable();
			$table->string('postcode')->nullable();
			$table->string('province')->nullable();
			$table->string('country')->nullable();
			$table->string('blood_type')->nullable();
			$table->string('mobile_number')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn(array(
				'full_name',
				'gender',
				'date_of_birth',
				'street_address',
				'city',
				'postcode',
				'province',
				'country',
				'blood_type',
				'mobile_number'
			));
		});
	}

}
