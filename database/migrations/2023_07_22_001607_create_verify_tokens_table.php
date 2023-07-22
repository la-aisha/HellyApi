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
        Schema::create('verify_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable;
            $table->string('token');
            //$table->boolean('is_activated')->default(0);
            //
            //$table->integer('created_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verify_tokens');
    }
};
