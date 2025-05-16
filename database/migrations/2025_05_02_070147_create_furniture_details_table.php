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
        Schema::create('furniture_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('furniture_type')->nullable();
            $table->string('material')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('color')->nullable();
            $table->string('condition')->nullable();
            $table->string('warranty')->nullable();
            $table->string('folding')->nullable();
            $table->string('age')->nullable();
            // New fields
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('handmade')->nullable();
            $table->string('origin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furniture_details');
    }
};
