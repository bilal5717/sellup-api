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
        Schema::create('property_rent_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('sub_type')->nullable();
            $table->string('furnish')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('storeys')->nullable();
            $table->integer('floor_level')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->string('area_unit')->nullable();
            $table->json('features')->nullable();
            $table->string('other_feature')->nullable();
            $table->string('rent_period')->default('monthly');
            $table->boolean('utilities_included')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_rent_details');
    }
};
