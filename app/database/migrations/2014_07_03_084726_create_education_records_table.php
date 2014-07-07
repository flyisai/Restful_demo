<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('education_records', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('type');
            $table->string('organization_name');
            $table->string('graduation_year');
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
        Schema::drop('education_records');
    }

}
