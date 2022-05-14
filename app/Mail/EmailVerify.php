<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;
    public $token='';
    public $email='';
    public $name='';
     
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token,$email='',$name='')
    {
        //
        $this->token = $token;
       $this->email=$email;
       $this->name=$name;
       

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->view('emails.email_verify')->subject('Forgot Password')->from('info@webmobril.com','Cannabis Expression');
       // return $this->view('view.name');
    }
}
