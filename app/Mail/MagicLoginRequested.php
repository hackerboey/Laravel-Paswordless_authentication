<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Auth\MagicAuthentication;


class MagicLoginRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $options;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, array $options)
    {
        $this->user=$user;
        $this->options=$options;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Magic login link')->view('email.magic_link')->with([

            'link'=>$this->buildLink(),
        ]);
    }

    public function buildLink()
    {
        return url('/login/magic/' . $this->user->token->token . '?' .http_build_query($this->options));
    }
}
