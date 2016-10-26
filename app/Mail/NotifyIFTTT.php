<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class NotifyIFTTT extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $ifttt)
    {
        $this->user  = $user;
        $this->ifttt = $ifttt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@' . env('MAILGUN_DOMAIN'))
                    ->subject('IFTTT notification')
                    ->view('emails.notify-ifttt', [
                        'user'    => $this->user,
                        'time'    => \Carbon\Carbon::now()->toDateTimeString(),
                        'ifttt'   => $this->ifttt
                    ]);
    }
}
