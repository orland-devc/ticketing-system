<?php

namespace App\Mail;

use App\Models\SignUpRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignUpRejected extends Mailable
{
    use Queueable, SerializesModels;

    public SignUpRequest $request;

    /**
     * Create a new message instance.
     */
    public function __construct(SignUpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'PSU HelpDeskPro - Your Request has been Rejected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.signup-rejected',
            with: [
                'name' => $this->request->name, // Pass name from the request
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
