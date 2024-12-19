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
            $table->id(); // Primary key, auto increment
            $table->string('email', 255)->unique()->notNullable(); // Email, unique, not null
            $table->string('password', 255)->notNullable(); // Password, not null
            $table->string('name', 255)->notNullable(); // Name, not null
            $table->boolean('active')->default(true); // Active, default true
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP')); // Created_at, default current timestamp
        });
        

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
