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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            
            // Required fields only
            $table->string('title');
            $table->enum('type', ['House', 'Apartment', 'Villa', 'Plot', 'Commercial']);
            $table->enum('status', ['Available', 'Pending', 'Sold', 'Rented'])->default('Available');
            
            // Optional fields
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('area', 10, 2)->nullable(); // Area in sq ft
            $table->decimal('price', 15, 2)->nullable(); // Price in INR
            $table->json('images')->nullable(); // Store image paths as JSON
            $table->json('features')->nullable(); // Store property features as JSON
            
            // Foreign key
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
