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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->string('registration_no')->unique();

            // Visitor Details
            $table->string('email')->unique();
            $table->string('title')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('gender')->nullable();
    
            $table->string('job_title');
            $table->string('job_function');
            $table->string('phone');

            // Company Details
            $table->string('company_name');

            $table->text('address')->nullable();

            $table->string('country');
            $table->string('pincode')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('website')->nullable();

            // Business
            $table->string('industry_segment');
            $table->string('business_nature');

            $table->string('primary_product_group');
            $table->json('additional_product_group')->nullable();

            $table->boolean('terms')->default(false);
            $table->boolean('agree_children_policy')->default(false);

            $table->boolean('status')->default(true);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
