<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
     
    /**
     * Create a new message instance.
     *
     * @return void
     */ 

    public $name;
    public $pass;
    public $email;
    public function __construct($name,$email,$pass)
    {
        //
        $this->email=$email;
        $this->name = $name;
        $this->pass=$pass;
       
         
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    

    public function build()
    {

        return $this->view('emails.welcome_user')->subject('Welcome To PropertyMD')->from('info@propertymd.biz','PropertyMD');
     /*   $address = 'sharvan01041994@gmail.com';
 
        $name = 'Sharvan';
 
        $subject = 'Laravel Email Test';
 
        return $this->view('admin.sendemail')
 
        ->from($address, $name)
 
        ->subject($subject);
        */
       // return $this->view('view.name');
       // return $this->view('view.name');
        //return $this->view('view.name');
         
    }
}
