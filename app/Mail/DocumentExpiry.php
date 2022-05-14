<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentExpiry extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $pass; 
    public $docs=array();   
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pass,$name,array $docs)
    {
        //
        $this->name = $name;
        $this->pass=$pass;
        $this->docs=$docs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.document_expiry_notification')->subject('Document Expiry Notification')->from('info@propertymd.biz','PropertyMD');
        //return $this->view('view.name');
    }
}
