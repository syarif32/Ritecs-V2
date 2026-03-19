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
    Schema::create('publishing_schemes', function (Blueprint $table) {
        $table->id();
        $table->string('icon');
        $table->string('title');
        $table->text('description');
        $table->string('feature'); // Teks unggulan di bawah deskripsi
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishing_schemes');
    }
};
