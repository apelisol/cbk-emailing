<?php
// database/migrations/2024_01_01_000004_create_sent_emails_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_email');
            $table->string('recipient_name');
            $table->string('subject');
            $table->longText('body');
            $table->enum('status', ['sent', 'pending', 'failed'])->default('pending');
            $table->string('error_message')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->foreignId('email_job_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};