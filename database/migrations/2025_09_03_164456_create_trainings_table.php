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
    Schema::create('trainings', function (Blueprint $table) {
        $table->id();
        $table->string('image_path');
        $table->string('title');
        $table->text('description');
        $table->string('schedule');
        $table->string('contact_person');
        $table->string('price');
        $table->string('price_period')->nullable(); 
        $table->string('price_note')->nullable(); 
        $table->string('button_text');
        $table->string('button_url');
        $table->timestamps();
    });
}
};
