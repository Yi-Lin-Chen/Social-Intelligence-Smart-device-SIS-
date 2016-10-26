<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Log;

class NotifyIFTTT extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $ifttt, $photo)
    {
        $this->user  = $user;
        $this->ifttt = $ifttt;
        $this->photo = $photo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('noreply@' . env('MAILGUN_DOMAIN'))
                     ->subject('IFTTT notification')
                     ->view('emails.notify-ifttt', [
                        'user'    => $this->user,
                        'time'    => \Carbon\Carbon::now()->toDateTimeString(),
                        'ifttt'   => $this->ifttt
                     ]);

        if( $this->photo != null ) {

            Log::info('Attach photo: ' . $this->photo);

            $mail = $this->from('noreply@' . env('MAILGUN_DOMAIN'))
                         ->subject('IFTTT notification')
                         ->view('emails.notify-ifttt', [
                            'user'    => $this->user,
                            'time'    => \Carbon\Carbon::now()->toDateTimeString(),
                            'ifttt'   => $this->ifttt
                         ])
                         ->attach($this->photo);
        }

        return $mail;
    }
}
