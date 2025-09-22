<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lead $lead
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Form Submission - ' . $this->lead->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-submitted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}