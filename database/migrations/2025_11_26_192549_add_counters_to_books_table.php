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
    Schema::table('books', function (Blueprint $table) {
        $table->integer('visitor_count')->default(0); 
        $table->integer('download_count')->default(0); 
    });
}

public function down()
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn(['visitor_count', 'download_count']);
    });
}
};
