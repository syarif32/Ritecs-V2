<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('haki_packages', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('old_price')->nullable();
        $table->string('new_price');
        $table->text('description')->nullable();
        $table->json('features')->nullable(); 
        $table->text('whatsapp_message');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('haki_packages');
    }
};
