<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DirectEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $content;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param Client $client
     * @param string $content
     * @param string $subject
     */
    public function __construct(Client $client, string $content, string $subject = 'Message from Central Bank of Kenya')
    {
        $this->client = $client;
        $this->content = $content;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.direct',
            with: [
                'client' => $this->client,
                'content' => $this->content,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
