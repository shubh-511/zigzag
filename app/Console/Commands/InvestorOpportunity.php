<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Subscription;
use App\Mail\InvestorOpportunities;

class InvestorOpportunity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investor:opportunities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Package status changed';

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
        $current_timestamp = Carbon::now()->timestamp;
       
	    $todaydate = date('Y-m-d'); 
	    $currenttime = date("H:i:s", time('H:i:s')); 
	
	    $time_stamp = $todaydate . " " .  $currenttime;
        //$result1 = DB::select('select * from users where roles_id = 2 and status = 1 and created_at < DATE_SUB(NOW(), INTERVAL 1 WEEK)');
        
        //for investors
		//$result1 = Subscription::where('end_date','<',$time_stamp)->where('subscription_type',2)->where('status',1)->get();
		
		$result1 = User::where('investor_flag',1)->where('status',1)->get();
		
        foreach($result1 as $notify_user)
        {
			Mail::to($email)->send(new InvestorOpportunities($notify_user->email,$notify_user->name),function($message){});
			//$review = Subscription::where('id',$notify_user->id)->first();
            //$review->status=0;
		    //$review->save();
		
        }
        ///end for investors
        
        
    }
}
