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
            $table->string('type')->default('campaign')->after('id');
            $table->text('content')->nullable()->change();
            $table->string('error', 500)->nullable()->after('status');
            
            // Rename body to content for consistency
            if (Schema::hasColumn('sent_emails', 'body')) {
                $table->renameColumn('body', 'content');
            }
            
            // Rename error_message to error for consistency
            if (Schema::hasColumn('sent_emails', 'error_message')) {
                $table->renameColumn('error_message', 'error');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sent_emails', function (Blueprint $table) {
            $table->dropColumn('type');
            
            // Revert column renames if they were changed
            if (Schema::hasColumn('sent_emails', 'content')) {
                $table->renameColumn('content', 'body');
            }
            
            if (Schema::hasColumn('sent_emails', 'error')) {
                $table->renameColumn('error', 'error_message');
            }
        });
    }
};
