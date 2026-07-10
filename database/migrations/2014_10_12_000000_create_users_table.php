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

            // Company
            $table->unsignedBigInteger('company_id')->nullable();

            // User Type
            $table->enum('type', ['admin', 'employee']);

            // Role
            $table->unsignedBigInteger('role_id');

            // Basic
            $table->string('username')->unique();
            $table->string('name');
            $table->json('permissions')->nullable();
            $table->string('email')->unique();
            $table->string('mobile', 20)->nullable()->unique();
            $table->string('password');

            // Profile
            $table->string('profile_image')->nullable();

            // Status
            $table->boolean('status')->default(true);

            // Login
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->nullOnDelete();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->cascadeOnDelete();
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