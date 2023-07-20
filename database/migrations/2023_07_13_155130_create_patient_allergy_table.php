<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_allergy', function (Blueprint $table) {
            $table->id();
            $table->string('firtsname');
            $table->string('lastname');

            $table->string('number');
            $table->string('ddn');
           
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('allergy_id');
            $table->timestamps();
        
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('allergy_id')->references('id')->on('allergies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_allergy');
    }
};
