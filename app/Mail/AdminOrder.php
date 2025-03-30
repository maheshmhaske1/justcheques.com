<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     */
    public function __construct($order)
    {
        $this->order = $order;

        // dd($this->order);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Placed Successfully',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.adminplace',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
    
        // Attach company_logo if it exists
        if (!empty($this->order->company_logo)) {
            $filePath = storage_path('app/public/logos/' . $this->order->company_logo);
            if (file_exists($filePath) && is_readable($filePath)) {
                $attachments[] = Attachment::fromPath($filePath)->as('company_logo.jpg')->withMime('image/jpeg');
            } else {
                \Log::error('Attachment company_logo not found or not readable: ' . $filePath);
            }
        }
    
        // Attach cheque_img if it exists
        if (!empty($this->order->cheque_img)) {
            $filePath = public_path('assets/front/img/' . basename($this->order->cheque_img));
            if (file_exists($filePath) && is_readable($filePath)) {
                $attachments[] = Attachment::fromPath($filePath)->as('cheque_image.jpg')->withMime('image/jpeg');
            } else {
                \Log::error('Attachment cheque_img not found or not readable: ' . $filePath);
            }
        }
    
        return $attachments;
    }


}
