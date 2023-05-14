<?php

namespace App\Mail;

use App\Models\Purchase_summary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Purchase_successfullyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase_summary;

    public function __construct(Purchase_summary $purchase_summary)
    {
        $this->purchase_summary = $purchase_summary;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Purchase Successfully Mail',
        );
    }

    public function content()
    {
        return new Content(
            view: 'admin.mail.purchase',
        );
    }

    public function attachments()
    {
        return [];
    }
}
