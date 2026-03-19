<?php

// database/migrations/xxxx_create_banks_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('bank_id');
            $table->string('bank_name', 100);
            $table->string('account_name', 150);
            $table->string('account_number', 50);
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'sender_name')) {
                $table->string('sender_name', 150)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('transactions', 'sender_bank')) {
                $table->string('sender_bank', 100)->nullable()->after('sender_name');
            }
            if (!Schema::hasColumn('transactions', 'bank_id')) {
                $table->unsignedBigInteger('bank_id')->nullable()->after('sender_bank');
                $table->foreign('bank_id')->references('bank_id')->on('banks')->onDelete('set null');
            }
        });

        // optional: add member_number in memberships (fase admin nanti)
        Schema::table('memberships', function (Blueprint $table) {
            if (!Schema::hasColumn('memberships', 'member_number')) {
                $table->string('member_number', 30)->nullable()->unique()->after('membership_id');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->dropColumn(['sender_name','sender_bank','bank_id']);
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('member_number');
        });

        Schema::dropIfExists('banks');
    }
}
