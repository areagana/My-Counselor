<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Facades\Support\Auth;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;
    //const userName = Auth::user()->firstName.' '.Auth::user()->lastName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userName = Auth::user()->firstName.' '.Auth::user()->lastName;
        return $this->from(Auth::user()->email,$userName)
                    ->view('emails.orders.shipped');
    }
}
