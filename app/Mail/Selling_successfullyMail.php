<?php

namespace App\Mail;

use App\Models\Selling_summary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Selling_successfullyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $selling_summary;

    public function __construct(Selling_summary $selling_summary)
    {
        $this->selling_summary = $selling_summary;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Selling Successfully Mail',
        );
    }

    public function content()
    {
        return new Content(
            view: 'admin.mail.selling',
        );
    }

    public function attachments()
    {
        return [];
    }
}
