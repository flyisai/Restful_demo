<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors', function(Blueprint $table)
		{
			$table->increments('id');                        
            $table->integer('user_id')->unsigned()->nullable();
			$table->string('name');
			$table->string('speciality');
			$table->string('street_address');
			$table->integer('city_id');
			$table->string('postcode');
			$table->integer('province_id');
			$table->string('country');
			$table->string('phone');
			$table->string('email');
			$table->string('license_number');
			$table->timestamps();
                        
            $table->engine = 'InnoDB';
            $table->index('user_id');
		});
                
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('doctors');
	}

}
