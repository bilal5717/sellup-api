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
        Schema::create('vehicle_details', function (Blueprint $table) {
       $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('vehicle_type')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->integer('kms_driven')->nullable();
            $table->decimal('monthly_installment', 12, 2)->nullable();
            $table->string('transmission')->nullable();
            $table->string('assembly')->nullable();
            $table->string('condition')->nullable();
            $table->string('registration_city')->nullable();
            $table->string('doc_type')->nullable();
            $table->integer('number_of_owners')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('registered')->nullable();
            $table->string('install_plan')->nullable();
            $table->decimal('down_payment', 12, 2)->nullable();
            $table->json('features')->nullable();
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_details');
    }
};
