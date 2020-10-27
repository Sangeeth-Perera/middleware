<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NIC');
            $table->string('Name');
            $table->string('DOB');
            $table->string('village');
            $table->string('Gender');
            $table->string('contactNumber')->nullable();
            $table->string('civilStatus')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('patient_updates');
    }
}
