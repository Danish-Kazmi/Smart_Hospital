<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('patient_id')->nullable();
            $table->char('discharged',4)->default('NO'); // YES | NO
            $table->bigInteger('ward_id')->unsigned()->nullable();
            $table->foreign('ward_id')->references('id')->on('wards');
            $table->date('discharged_date')->nullable();
            $table->string('description')->nullable();
            $table->string('discharged_officer')->nullable();
            $table->string('patient_inventory')->nullable();
            
            // $table->string('incharge_doctor');
            $table->string('house_doctor')->nullable();
            $table->string('approved_doctor')->nullable();
            $table->string('disease')->nullable();
            $table->integer('duration')->nullable();
            $table->string('condition')->nullable();
            $table->string('certified_officer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inpatients');
    }
}
