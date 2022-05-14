<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendForgotEmail extends Mailable
{
    use Queueable, SerializesModels;
     
    /**
     * Create a new message instance.
     *
     * @return void
     */ 
    public $name;
    //public $pass;
    public $email;
   // public $password;
    public function __construct($name, $email)
    {
        //
       $this->name = $name;
       //$this->pass=$pass;
        $this->email=$email;     
        //$this->password=$password;     
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    

    public function build()
    {
        return $this->view('emails.sendforgotemail')->subject('Forgot Password')->from('info@locum.com','Locum');
    }
}
