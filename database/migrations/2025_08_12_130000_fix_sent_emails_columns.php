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
        Schema::table('sent_emails', function (Blueprint $table) {
            // Check if body column exists and content doesn't exist
            if (Schema::hasColumn('sent_emails', 'body') && !Schema::hasColumn('sent_emails', 'content')) {
                $table->renameColumn('body', 'content');
            }
            
            // Make sure type column exists
            if (!Schema::hasColumn('sent_emails', 'type')) {
                $table->string('type')->default('campaign')->after('id');
            }
            
            // Make sure error column exists (renamed from error_message)
            if (Schema::hasColumn('sent_emails', 'error_message') && !Schema::hasColumn('sent_emails', 'error')) {
                $table->renameColumn('error_message', 'error');
            } elseif (!Schema::hasColumn('sent_emails', 'error')) {
                $table->string('error', 500)->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sent_emails', function (Blueprint $table) {
            if (Schema::hasColumn('sent_emails', 'content')) {
                $table->renameColumn('content', 'body');
            }
            
            if (Schema::hasColumn('sent_emails', 'type')) {
                $table->dropColumn('type');
            }
            
            if (Schema::hasColumn('sent_emails', 'error')) {
                $table->renameColumn('error', 'error_message');
            }
        });
    }
};
