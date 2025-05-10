<?php

namespace App\Mail;

use App\Models\Renewal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class RenewalNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public readonly string $contactName, public readonly Renewal $renewal, public readonly Collection $bankAccounts)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
		$mainDomain = $this->renewal
			->hostingAccounts()
			->first()
			->mainDomain
			->name;

        return new Envelope(
            subject: 'Aviso de renovación de servicios - ' . $mainDomain,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.renewal.notification',
//			with: ['contactName' => $this->contactName, 'renewal' => $this->renewal, 'bankAccounts' => $this->bankAccounts],
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
