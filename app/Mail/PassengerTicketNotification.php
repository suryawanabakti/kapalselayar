<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PassengerTicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $passenger;

    public function __construct($passenger)
    {
        $this->passenger = $passenger;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Konfirmasi Tiket - ' . ($this->passenger->ticket_code ?? '')); 
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.passenger-ticket');
    }

    public function attachments(): array
    {
        return [];
    }
}
