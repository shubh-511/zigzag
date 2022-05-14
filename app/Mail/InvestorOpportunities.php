<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvestorOpportunities extends Mailable
{
    use Queueable, SerializesModels;
     
    /**
     * Create a new message instance.
     *
     * @return void
     */ 
    
    public $email;
    public $name;
    public $pitch;
   
    public function __construct($email, $name, $pitch)
    {
      
        $this->email=$email;
        $this->name = $name;
        $this->pitch=$pitch;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    

    public function build()
    {
        return $this->view('emails.sendopportunity')->subject('New Investor Oppotunity')->from('info@webmobril.org','Cannabis Expression');
    }
}
