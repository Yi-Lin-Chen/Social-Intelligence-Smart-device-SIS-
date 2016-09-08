<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class RequestForAccess extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $req_id)
    {
        // $user 是要求權限的使用者
        $this->user   = $user;
        $this->req_id = $req_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@' . env('MAILGUN_DOMAIN'))
                    ->text('emails.request-notify', [
                        'name'  => $this->user->name,
                        'req_id'=> $this->req_id,
                        'time'  => \Carbon\Carbon::now()->toDateTimeString()
                    ]);
    }
}
