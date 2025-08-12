<?php
namespace App\Jobs;

use App\Events\EmailSent;
use App\Models\Client;
use App\Models\EmailJob;
use App\Models\SentEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendScheduledEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public EmailJob $emailJob,
        public Client $client
    ) {}

    public function handle(): void
    {
        try {
            // Create sent email record
            $sentEmail = SentEmail::create([
                'recipient_email' => $this->client->email,
                'recipient_name' => $this->client->name,
                'subject' => $this->emailJob->subject,
                'body' => $this->emailJob->body,
                'status' => 'pending',
                'email_job_id' => $this->emailJob->id,
                'client_id' => $this->client->id,
                'user_id' => $this->emailJob->user_id,
            ]);

            // Replace placeholders if template
            $subject = $this->emailJob->subject;
            $body = $this->emailJob->body;

            if ($this->emailJob->type === 'template' && $this->emailJob->template) {
                $replaced = $this->emailJob->template->replacePlaceholders($this->client);
                $subject = $replaced['subject'];
                $body = $replaced['body'];
            } else {
                // Replace placeholders in custom messages too
                $subject = str_replace(
                    ['{{name}}', '{{email}}', '{{phone}}'],
                    [$this->client->name, $this->client->email, $this->client->phone ?? ''],
                    $subject
                );
                $body = str_replace(
                    ['{{name}}', '{{email}}', '{{phone}}'],
                    [$this->client->name, $this->client->email, $this->client->phone ?? ''],
                    $body
                );
            }

            // Send email
            Mail::html($body, function ($message) use ($subject) {
                $message->to($this->client->email, $this->client->name)
                        ->subject($subject);
            });

            // Update sent email record
            $sentEmail->update([
                'status' => 'sent',
                'sent_at' => now(),
                'subject' => $subject,
                'body' => $body,
            ]);

            // Fire event
            EmailSent::dispatch($sentEmail);

        } catch (\Exception $e) {
            // Update sent email record with error
            if (isset($sentEmail)) {
                $sentEmail->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }

            throw $e;
        }
    }
}