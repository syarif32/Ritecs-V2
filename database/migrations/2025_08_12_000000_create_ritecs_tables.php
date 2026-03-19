<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // // ROLES
        // Schema::create('roles', function (Blueprint $table) {
        //     $table->bigIncrements('role_id');
        //     $table->string('role_name', 100)->unique();
        // });

        // USERS
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            // $table->unsignedBigInteger('role_id')->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->string('nik', 50)->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('img_path', 255)->nullable();
            $table->string('ktp_path', 255)->nullable();
            $table->timestamps();

            // $table->foreign('role_id')->references('role_id')->on('roles');
        });

        // MEMBERSHIPS
        Schema::create('memberships', function (Blueprint $table) {
            $table->bigIncrements('membership_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->date('start_date');
            $table->date('end_date');

            $table->foreign('user_id')->references('user_id')->on('users');
        });

        // TRANSACTIONS
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('membership_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending','paid','failed'])->default('pending');
            $table->string('proof_path', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('membership_id')->references('membership_id')->on('memberships');
        });

        // BOOKS
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('book_id');
            $table->string('title', 255);
            $table->text('synopsis')->nullable();
            $table->string('publisher', 255)->nullable();
            $table->integer('pages')->nullable();
            $table->decimal('width', 6, 2)->nullable();
            $table->decimal('length', 6, 2)->nullable();
            $table->decimal('thickness', 6, 2)->nullable();
            $table->date('publish_date')->nullable();
            $table->string('isbn', 50)->unique()->nullable();
            $table->string('cover_path', 255)->nullable();
            $table->string('ebook_path', 255)->nullable();
            $table->decimal('print_price', 12, 2)->nullable();
            $table->decimal('ebook_price', 12, 2)->nullable();
            $table->timestamps();
        });

        // WRITERS
        Schema::create('writers', function (Blueprint $table) {
            $table->bigIncrements('writer_id');
            $table->string('name', 255);
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users');
        });

        // PIVOT BOOK-WRITER
        Schema::create('book_writer', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('writer_id');
            $table->primary(['book_id', 'writer_id']);

            $table->foreign('book_id')->references('book_id')->on('books')->onDelete('cascade');
            $table->foreign('writer_id')->references('writer_id')->on('writers')->onDelete('cascade');
        });

        // CATEGORIES
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->string('name', 255);
            $table->enum('type', ['book', 'journal']);
        });

        // PIVOT BOOK-CATEGORY
        Schema::create('book_category', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('category_id');
            $table->primary(['book_id', 'category_id']);

            $table->foreign('book_id')->references('book_id')->on('books')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });

        // JOURNALS
        Schema::create('journals', function (Blueprint $table) {
            $table->bigIncrements('journal_id');
            $table->string('title', 255);
            $table->text('abstract')->nullable();
            $table->text('authors')->nullable();
            $table->date('publish_date')->nullable();
            $table->string('file_path', 255)->nullable();
            $table->timestamps();
        });

        // KEYWORDS
        Schema::create('keywords', function (Blueprint $table) {
            $table->bigIncrements('keyword_id');
            $table->string('name', 255)->unique();
        });

        // PIVOT JOURNAL-KEYWORD
        Schema::create('journal_keyword', function (Blueprint $table) {
            $table->unsignedBigInteger('journal_id');
            $table->unsignedBigInteger('keyword_id');
            $table->primary(['journal_id', 'keyword_id']);

            $table->foreign('journal_id')->references('journal_id')->on('journals')->onDelete('cascade');
            $table->foreign('keyword_id')->references('keyword_id')->on('keywords')->onDelete('cascade');
        });

        // CONTACT MESSAGES
        Schema::create('contacts', function (Blueprint $table) {
           $table->id('contact_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address'); 
            $table->string('subject');
            $table->text('message');
            $table->timestamps(); 
        });

        // MAIN BANNERS
        Schema::create('main_banners', function (Blueprint $table) {
            $table->bigIncrements('banner_id');
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('img_path', 255)->nullable();
            $table->string('link', 255)->nullable();
        });

        // FAQ
        Schema::create('faq', function (Blueprint $table) {
            $table->bigIncrements('faq_id');
            $table->text('question');
            $table->text('answer');
        });

        // TEAMS
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('team_id');
            $table->string('name', 255)->nullable();
            $table->string('position', 255)->nullable();
            $table->string('img_path', 255)->nullable();
        });

        // TESTIMONIS
        Schema::create('testimonis', function (Blueprint $table) {
            $table->bigIncrements('testimoni_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('content')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('user_id')->on('users');
        });

        // BLOGS
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('blog_id');
            $table->string('title', 255);
            $table->text('content')->nullable();
            $table->string('author', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('testimonis');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('faq');
        Schema::dropIfExists('main_banners');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('journal_keyword');
        Schema::dropIfExists('keywords');
        Schema::dropIfExists('journals');
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('book_writer');
        Schema::dropIfExists('writers');
        Schema::dropIfExists('books');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('memberships');
        Schema::dropIfExists('users');
        // Schema::dropIfExists('roles');
    }
};
