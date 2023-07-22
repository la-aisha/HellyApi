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
        Schema::create('medecins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('firstname');
            $table->string('lastname');
            $table->string('address');

            $table->boolean('is_activated')->default(0);


            $table->string('email');

            $table->string('number');
            $table->string('ddn');
           

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('speciality_id');

            
            $table->foreign('hopital_id')->references('id')->on('hopitals')->onDelete('cascade');
            $table->foreign('speciality_id')->references('id')->on('specialities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medecins');
    }
};
