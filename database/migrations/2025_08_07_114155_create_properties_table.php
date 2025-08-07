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
            $table->string('pincode', 10);
            $table->enum('type', ['House', 'Apartment', 'Villa', 'Commercial', 'Plot']);
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('area_sqft', 10, 2)->nullable();
            $table->decimal('price', 15, 2); // INR pricing
            $table->enum('status', ['Available', 'Sold', 'Pending', 'Under Contract']);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->json('images')->nullable(); // Store image paths as JSON
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
