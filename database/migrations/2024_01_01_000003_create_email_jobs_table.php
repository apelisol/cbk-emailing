<?php
// database/migrations/2024_01_01_000003_create_email_jobs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->longText('body');
            $table->json('recipient_ids'); // Array of client IDs
            $table->enum('type', ['template', 'custom']);
            $table->foreignId('template_id')->nullable()->constrained('email_templates')->onDelete('cascade');
            $table->datetime('scheduled_at');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_jobs');
    }
};