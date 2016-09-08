<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Access;

class NotifyUserWithQRCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Access $access)
    {
        $this->access = $access;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@' . env('MAILGUN_DOMAIN'))
                    ->subject('Access granted with QRCode')
                    ->view('emails.notify-user', [
                        'access'  => $this->access,
                        'user'    => $this->access->user()->first(),
                        'time'    => \Carbon\Carbon::now()->toDateTimeString()
                    ]);
    }
}
