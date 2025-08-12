<?php
namespace App\Listeners;

use App\Events\EmailSent;
use App\Models\EmailJob;

class UpdateEmailJobStatus
{
    public function handle(EmailSent $event): void
    {
        $emailJob = $event->sentEmail->emailJob;
        
        if (!$emailJob) return;

        // Check if all emails for this job have been processed
        $totalEmails = count($emailJob->recipient_ids ?? []);
        $processedEmails = $emailJob->sentEmails()->whereIn('status', ['sent', 'failed'])->count();

        if ($processedEmails >= $totalEmails) {
            $emailJob->update(['status' => 'completed']);
        }
    }
}