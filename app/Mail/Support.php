<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Support extends Mailable
{
    use Queueable, SerializesModels;
     
    /**
     * Create a new message instance.
     *
     * @return void
     */ 
    public $name;
    public $email;
    public $sub;
    public $mess;
    public function __construct($name, $email, $sub, $mess)
    {
        //
       $this->name = $name;
        $this->email=$email;     
        $this->sub=$sub;     
        $this->mess=$mess;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    

    public function build()
    {
        return $this->view('emails.sendsupport')->subject('New Contact')->from('info@webmobril.org','Cannabis Expression');
    }
}
