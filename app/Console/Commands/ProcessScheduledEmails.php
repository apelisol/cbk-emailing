<?php
namespace App\Console\Commands;

use App\Jobs\SendScheduledEmailJob;
use App\Models\Client;
use App\Models\EmailJob;
use Illuminate\Console\Command;

class ProcessScheduledEmails extends Command
{
    protected $signature = 'emails:process-scheduled';
    protected $description = 'Process scheduled emails that are due to be sent';

    public function handle(): int
    {
        $scheduledJobs = EmailJob::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->get();

        $this->info("Found {$scheduledJobs->count()} scheduled email jobs to process");

        foreach ($scheduledJobs as $emailJob) {
            $emailJob->update(['status' => 'processing']);

            $clients = Client::whereIn('id', $emailJob->recipient_ids ?? [])->get();

            foreach ($clients as $client) {
                SendScheduledEmailJob::dispatch($emailJob, $client);
            }

            $this->info("Queued emails for job ID: {$emailJob->id}");
        }

        return 0;
    }
}