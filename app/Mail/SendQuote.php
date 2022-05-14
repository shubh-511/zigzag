<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendQuote extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $msg='';
    public $user_name;
    public $user_email;
    public $user_mobile;
    public $business_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title='',$msg='',$user_name='',$user_email='',$user_mobile='',$business_name='')
    {
        //
        $this->title = $title;
       $this->msg=$msg;
       $this->user_name=$user_name;
       $this->user_email=$user_email;
       $this->user_mobile=$user_mobile;
       $this->business_name=$business_name;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sendquote')->subject('PropertyMD Quote for you')->from('info@propertymd.biz','PropertyMD');
       // return $this->view('view.name');
    }
}
