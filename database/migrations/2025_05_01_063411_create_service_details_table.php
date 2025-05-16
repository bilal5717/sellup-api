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
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('service_type');
            $table->enum('business_type', ['individual', 'company'])->default('individual');
            $table->string('business_name')->nullable();
            $table->string('availability')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('special_field')->nullable();
            $table->string('special_type_field')->nullable();
            $table->string('type_for_catering')->nullable();
            $table->string('type_for_carpool')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
