<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientAdmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_admits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nic')->nullable();
            $table->string('name')->nullable();
             $table->string('dob')->nullable();
            $table->string('village')->nullable();
            $table->string('gender')->nullable();
            $table->string('contactNumber')->nullable();
            $table->string('civilStatus')->nullable();
            
            $table->string('ward')->nullable(); 
            $table->string('doctor')->nullable(); 
            $table->string('remarks')->nullable(); 
            $table->string('admissionDate')->nullable();
            $table->string('dischargeDate')->nullable();
            $table->string('dischargeICD_Code')->nullable();
            $table->string('dischargeICD_Text')->nullable();
            $table->string('dischargeIMMR_Code')->nullable();
            $table->string('dischargeDoctor')->nullable();
            $table->string('dischargeOutcome')->nullable();
            $table->string('dischargeRemarks')->nullable();
            $table->string('complaint')->nullable();
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
        Schema::dropIfExists('patient_admits');
    }
}
