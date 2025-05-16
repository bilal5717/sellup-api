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
        Schema::create('mobile_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('condition')->nullable();
            $table->string('pta_status')->nullable();
            $table->string('storage')->nullable();
            $table->string('memory')->nullable();
            $table->string('battery_status')->nullable();
            $table->string('accessory_type')->nullable();
            $table->string('charging_cable_type')->nullable();
            $table->string('device_type')->nullable();
            $table->string('charger_type')->nullable();
            $table->string('headphone_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_details');
    }
};
