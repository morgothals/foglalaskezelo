<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public array $booking;

    public function __construct(array $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Foglalás visszaigazolás')
                    ->view('emails.booking.confirmation_plain')
                    ->with('booking', $this->booking);
    }
}
