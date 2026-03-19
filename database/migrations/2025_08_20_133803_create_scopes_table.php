<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//     /**
//      * Run the migrations.
//      */
//     public function up() {
//     Schema::create('scopes', function (Blueprint $table) {
//         $table->id();
//         $table->string('name');
//         $table->timestamps();
//     });
// }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('scopes');
//     }
public function up()
{
    // Tambahkan pengecekan if (!Schema::hasTable('scopes'))
    if (!Schema::hasTable('scopes')) {
        Schema::create('scopes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
}
};
