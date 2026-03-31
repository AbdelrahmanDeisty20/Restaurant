<?php

namespace App\Mail;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCouponMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Coupon $coupon
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('New Discount Coupon Available! 🎁'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_coupon',
        );
    }
}
