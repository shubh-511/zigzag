<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Subscription;


class PackageExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:status';

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
		$result1 = Subscription::where('end_date','<',$time_stamp)->where('subscription_type',2)->where('status',1)->get();
        foreach($result1 as $notify_user)
        {
			
			$review = Subscription::where('id',$notify_user->id)->first();
            $review->status=0;
			$review->save();
			
			$userupd = User::where('id',$notify_user->user_id)->first();
			$userupd->investor_flag=0;
			$userupd->save();

             
        }
        ///end for investors
        
        //for entrepreneur
        $result2 = Subscription::where('end_date','<',$time_stamp)->where('subscription_type',3)->where('status',1)->get();
        foreach($result2 as $notify_user1)
        {
			
			$review1 = Subscription::where('id',$notify_user1->id)->first();
            $review1->status=0;
			$review1->save();
			
			$userupd1 = User::where('id',$notify_user1->user_id)->first();
			$userupd1->entrepreneur_flag=0;
			$userupd1->save();

             
        }
        ///end for entrepreneur
        
        //for chat
        $result3 = Subscription::where('end_date','<',$time_stamp)->where('subscription_type',4)->where('status',1)->get();
        foreach($result3 as $notify_user2)
        {
			
			$review2 = Subscription::where('id',$notify_user2->id)->first();
            $review2->status=0;
			$review2->save();
			
			$userupd2 = User::where('id',$notify_user2->user_id)->first();
			$userupd2->chat_flag=0;
			$userupd2->save();

             
        }
        ///end for chat
        
        //for News
        $result4 = Subscription::where('end_date','<',$time_stamp)->where('subscription_type',5)->where('status',1)->get();
        foreach($result4 as $notify_user3)
        {
			
			$review3 = Subscription::where('id',$notify_user3->id)->first();
            $review3->status=0;
			$review3->save();
			
			$userupd3 = User::where('id',$notify_user3->user_id)->first();
			if($userupd3->articles_access == 'unlimited')
			{
			    $userupd3->articles_access=null;
			}
			$userupd3->news_flag=0;
			$userupd3->articles_remaining=0;
			$userupd3->save();

             
        }
        ///end for news
    }
}
