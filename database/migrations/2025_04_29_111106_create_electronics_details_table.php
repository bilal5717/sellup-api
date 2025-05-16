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
        Schema::create('electronics_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->index();
            $table->string('type')->nullable();
            $table->string('brand')->nullable();
            $table->string('no_taps')->nullable();
            $table->string('water_dispensers')->nullable();
            $table->string('model')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('function_type')->nullable();
            $table->string('doors')->nullable();
            $table->string('power')->nullable();
            $table->string('heater_type')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('dryer_load')->nullable();
            $table->string('kilowatt')->nullable();
            $table->string('wattage')->nullable();
            $table->string('wattageups')->nullable();
            $table->string('sensor_size')->nullable();
            $table->string('capacity')->nullable();
            $table->string('condition')->nullable();
            $table->string('wifi')->nullable();
            $table->string('warranty')->nullable();
            $table->string('age')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electronics_details');
    }
};
