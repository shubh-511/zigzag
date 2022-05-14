<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use App\Wallet;
class PaymentTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment Transfer automatically to provider account after 72 hours';

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
        //
        $now= Carbon::now();
        $before72hours=$now->addDays(-3);
        $current=Carbon::now();
        $before5days=$current->addDays(-5);
        $bookings=Booking::where('end_time','>=',$before72hours)->where('end_time','<=',$before5days)->where('status','7')->get();
        
        $stripe=new StripeController;
        foreach($bookings as $booking)
        {
            
            $stripe->transferMoney($booking);    
            /*
            $due_provider=Wallet::where('user_id',$booking->business_id)->where('booking_id',$booking->id)->where('status','0')->get();
            if(!empty($due_provider))
            {
                
            }
            */
            
            
            /*$review=Review::where('sender_id',$booking->user_id)->where('booking_id',$booking->id)->where('user_id',$booking->business_id)->first();
            if(empty($review))
            {
                $review=new Review;
                $review->sender=$booking->user_id;
                $review->user_id=$booking->business_id;
                $review->booking_id=$booking->id;
                $review->review_heading="Thank you";
                $review->slug=str_slug("Thank you");
                $review->content="Excellent Service Provided Thank you";
                $review->rating=10;
                $review->save();
            }
            */
            
        }
        
    }
}
