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
            $table->id(); // auto-incrementing primary key
            $table->string('name'); // user name
            $table->string('email')->unique(); // user email (unique constraint)
            $table->timestamp('email_verified_at')->nullable(); // email verification timestamp
            $table->string('password'); // user password
            $table->rememberToken(); // for "remember me" functionality
            $table->timestamps(); // created_at, updated_at timestamps
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
