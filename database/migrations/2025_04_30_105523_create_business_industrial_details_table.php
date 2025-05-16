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
        Schema::create('business_industrial_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('business_type')->nullable();
            $table->string('special_field')->nullable();
            $table->string('sub_category_type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('seller_type')->nullable();
            $table->string('condition')->nullable();
            $table->string('operation_scale')->nullable();
            $table->text('specifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_industrial_details');
    }
};
