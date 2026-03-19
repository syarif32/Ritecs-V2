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
    Schema::table('haki_packages', function (Blueprint $table) {
        $table->string('whatsapp_number')->nullable()->after('whatsapp_message');
    });
}

public function down(): void
{
    Schema::table('haki_packages', function (Blueprint $table) {
        $table->dropColumn('whatsapp_number');
    });
}

};
