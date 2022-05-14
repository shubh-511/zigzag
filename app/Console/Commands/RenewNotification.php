<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Subscription;


class RenewNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification send';

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
		$result1 = Subscription::where('subscription_type', 2)->get();
        foreach($result1 as $notify_user)
        {
            $current = $notify_user->end_date;
            
            //echo 'thisiss'.$current; die;
			$trialExpires = (new Carbon($notify_user->end_date))->addDays(-1);
			if(($trialExpires < $time_stamp) && ($current > $time_stamp))
			{
    			$userupd = User::where('id',$notify_user->user_id)->first();
    			$userupd->notify_investor=1;
    			$userupd->save();
			}
			else
			{
			    $userupd = User::where('id',$notify_user->user_id)->first();
    			$userupd->notify_investor=0;
    			$userupd->save();
			}
        }
        
        //for entrepreneur
		
		$result2 = Subscription::where('subscription_type', 3)->get();
        foreach($result2 as $notify_user1)
        {
            $current1 = $notify_user1->end_date;
            
            //echo 'thisiss'.$current; die;
			$trialExpires1 = (new Carbon($notify_user1->end_date))->addDays(-1);
			if(($trialExpires1 < $time_stamp) && ($current1 > $time_stamp))
			{
    			$userupd1 = User::where('id',$notify_user1->user_id)->first();
    			$userupd1->notify_entrepreneur=1;
    			$userupd1->save();
			}
			else
			{
			    $userupd1 = User::where('id',$notify_user1->user_id)->first();
    			$userupd1->notify_entrepreneur=0;
    			$userupd1->save();
			}
        }
        
        //for chat
		
		$result3 = Subscription::where('subscription_type', 4)->get();
        foreach($result3 as $notify_user2)
        {
            $current2 = $notify_user2->end_date;
            
            //echo 'thisiss'.$current; die;
			$trialExpires2 = (new Carbon($notify_user2->end_date))->addDays(-1);
			if(($trialExpires2 < $time_stamp) && ($current2 > $time_stamp))
			{
    			$userupd2 = User::where('id',$notify_user2->user_id)->first();
    			$userupd2->notify_chat=1;
    			$userupd2->save();
			}
			else
			{
			    $userupd2 = User::where('id',$notify_user2->user_id)->first();
    			$userupd2->notify_chat=0;
    			$userupd2->save();
			}
        }
        
        //for news
		
		$result4 = Subscription::where('subscription_type', 5)->get();
        foreach($result4 as $notify_user3)
        {
            $current3 = $notify_user3->end_date;
            
            //echo 'thisiss'.$current; die;
			$trialExpires3 = (new Carbon($notify_user3->end_date))->addDays(-1);
			if(($trialExpires3 < $time_stamp) && ($current3 > $time_stamp))
			{
    			$userupd3 = User::where('id',$notify_user3->user_id)->first();
    			$userupd3->notify_news=1;
    			$userupd3->save();
			}
			else
			{
			    $userupd3 = User::where('id',$notify_user3->user_id)->first();
    			$userupd3->notify_news=0;
    			$userupd3->save();
			}
        }
        
       
    }
}
