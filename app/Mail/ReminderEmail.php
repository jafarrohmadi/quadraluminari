<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $name;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $name
     */
    public function __construct($data, $name)
    {
        $this->data = $data;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@quadraluminari.com')->view('mail.reminder');
    }
}
