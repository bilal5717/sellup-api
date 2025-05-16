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
        Schema::create('fashion_beauty_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('gender')->nullable();
            $table->string('fabric')->nullable();
            $table->string('material')->nullable();
            $table->string('Footcategory')->nullable();
            $table->string('condition')->nullable();
            $table->string('age')->nullable();
            $table->string('language')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fashion_beauty_details');
    }
};
