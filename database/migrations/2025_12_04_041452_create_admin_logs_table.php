<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('admin_logs', function (Blueprint $table) {
        $table->id();
        
        $table->unsignedBigInteger('actor_id')->nullable(); 
        
        $table->unsignedBigInteger('target_id')->nullable(); 
       
        $table->string('action_type'); 
        
        $table->text('description')->nullable(); 
        $table->timestamps();

        // Relasi ke tabel users (karena PK user kamu user_id)
        $table->foreign('actor_id')->references('user_id')->on('users')->onDelete('set null');
        $table->foreign('target_id')->references('user_id')->on('users')->onDelete('set null');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};
