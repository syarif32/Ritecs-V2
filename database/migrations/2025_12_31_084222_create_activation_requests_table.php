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
        Schema::create('activation_requests', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            
           
            $table->string('reason')->nullable();
            
         
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
           
            $table->unsignedBigInteger('processed_by')->nullable();
            
            $table->timestamps();

    
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            
            $table->foreign('processed_by')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activation_requests');
    }
};