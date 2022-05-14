<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $role;
    public $subject;
    public $message;
    
    public function __construct($name,$role,$subject,$message)
    {
        $this->name = $name;
        $this->role = $role;
        $this->subject=$subject;
        $this->message=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->view('emails.contactmail_admin')->subject('Contact Us')->from('info@zig-zag.com','Zig-Zag');
    }
}


