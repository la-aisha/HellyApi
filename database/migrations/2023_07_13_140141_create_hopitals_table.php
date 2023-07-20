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
        Schema::create('hopitals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('hopital_name');
            $table->string('email');
            $table->string('number');
            $table->string('link');
            $table->string('description');
            $table->string('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hopitals');
    }
};
