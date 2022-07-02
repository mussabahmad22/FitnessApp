<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RatingsEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $user_name;
    public $class_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ratings, $name, $class_name)
    {
        $this->details = $ratings;
        $this->user_name = $name;
        $this->class_name = $class_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rating Email By User From Fitness App')
            ->view('email.rating_mail');
    }
}
