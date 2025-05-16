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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('username')->nullable()->unique(); // Made nullable
            $table->string('email')->nullable()->unique(); // Made nullable
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // Made nullable
            $table->timestamp('otp_sent_at')->nullable();           // 🕒 When OTP was sent
            $table->timestamp('phone_verified_at')->nullable();     // ✅ When phone was verified
            $table->boolean('user_is_system_admin')->default(false);
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('phone_id')->nullable();
            $table->string('user_phone')->nullable();
            $table->text('user_address')->nullable();
            $table->text('user_about_me')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('code')->nullable();
            
            $table->float('over_all_ratting', 3, 2)->default(0);
            $table->boolean('is_show_email')->default(true);
            $table->boolean('is_show_phone')->default(true);
            $table->boolean('is_vendor')->default(false);
            $table->text('user_location')->nullable();
            
            $table->rememberToken();
            $table->string('password_reset_code')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
