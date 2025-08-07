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
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->enum('type', ['House', 'Apartment', 'Villa', 'Plot', 'Commercial']);
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('area', 10, 2); // Area in sq ft
            $table->decimal('price', 15, 2); // Price in INR
            $table->enum('status', ['Available', 'Pending', 'Sold', 'Rented'])->default('Available');
            $table->json('images')->nullable(); // Store image paths as JSON
            $table->json('features')->nullable(); // Store property features as JSON
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
