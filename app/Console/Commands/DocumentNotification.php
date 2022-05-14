<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\User;
use App\Mail\SendEmail;
use App\Mail\DocumentExpiry;
use Carbon\Carbon;

class DocumentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify Documents for Expiry date and send email to the user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
      //  $email=$request['email'];
        /*
       $user=User::where('email',$email)->first();
       if(!empty($user))
       {
      Mail::to($user->email)->send(new SendEmail($user->txtpassword,$user->name),function($message){

      });
    */
        $doc_data=array();
        $user_emails=array();
        $status=false;
        $current=Carbon::today();
        
        $exp_date=$current->addDays(5);


        $users ='sharvan@webmobriltechnologies.com'; 

        $notify_users=User::with('user_documents')->where('upgraded_business','1')->where('status','1')->get();

        foreach($notify_users as $notify_user)
        {   
          foreach($notify_user->user_documents as $docs)
            {
               if(strtotime($docs->dl_exp_date)-strtotime($current)<=5  && strtotime($docs->dl_exp_date)-strtotime($current)>=0)
                {
                    array_push($doc_data,'State Issued Driver License');
                    array_push($doc_data,$docs->dl_doc_no);
                    array_push($doc_data,$docs->dl_exp_date);
                    $status=true;
                }
                if(strtotime($docs->ssc_exp_date)-strtotime($current)<=5 && strtotime($docs->ssc_exp_date)-strtotime($current)>=0)
                {
                    array_push($doc_data,'Social Security Card');
                    array_push($doc_data,$docs->ssc_doc_no);
                    array_push($doc_data,$docs->ssc_exp_date);
                    $status=true;
                }
                if(strtotime($docs->dl_exp_date)-strtotime($current)<=5 && strtotime($docs->dl_exp_date)-strtotime($current)>=0)
                {
                    array_push($doc_data,'State Issued Driver License');
                    array_push($doc_data,$docs->dl_doc_no);
                    array_push($doc_data,$docs->dl_exp_date);
                    $status=true;
                }
                if(strtotime($docs->insurance_exp_date)-strtotime($current)<=5 && strtotime($docs->insurance_exp_date)-strtotime($current)>=0)
                {
                    array_push($doc_data,'Insurance');
                    array_push($doc_data,$docs->insurance_exp_date_doc_no);
                    array_push($doc_data,$docs->insurance_exp_date_exp_date);
                    $status=true;
                }
                if(strtotime($docs->certification_exp_date)-strtotime($current)<=5 && strtotime($docs->certification_exp_date)-strtotime($current)>=0)
                {
                    array_push($doc_data,'Certification');
                    array_push($doc_data,$docs->certification_exp_date_doc_no);
                    array_push($doc_data,$docs->certification_exp_date_exp_date);
                    $status=true;
                }
                if(strtotime($docs->cvd_exp_date)-strtotime($current)<=5 && strtotime($docs->cvd_exp_date)-strtotime($current)>=0)
                {
                    array_push($doc_data,'Corporate Vehicle Document');
                    array_push($doc_data,$docs->cvd_doc_no);
                    array_push($doc_data,$docs->cvd_exp_date);
                    $status=true;
                }
            }
            if($status==true)
            {
                array_push($user_emails,$notify_user->email);
            }  
        } 


              //echo $docs->dl_doc_no;
             
               // die;
              //echo '<pre>';print_r($userdata->user_documents);
               
            /*
            */

        //here will use Loop for sending mail to all user whose docs has been expired

            Mail::to($users)->send(new DocumentExpiry($notify_user->txtpassword,$notify_user->name,$user_emails),function($message){
            });
           
             
       

      /*  $users ='sharvan@webmobriltechnologies.com'; 
 
            Mail::Send('emails.mailme', ['user' => $users], function ($mail) use ($users){
            $mail->to($users)
                ->from('sharvan01041994@gmail.com', 'PropertyMD')
                ->subject('PropertyMD | Document Expiry Notification!');
                //->body('u'=>$u);
            });
                */

        $this->info('Document Expiry Notification sent successfully!');
    }
}

       
