<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Booking;
use App\Review;
use App\User;
use Carbon\Carbon;

class SendReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:review';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Review to User or Provider within 24 hours If User or Provider not give review';

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
        $before24hours=$now->addDays(-1);
        $bookings=Booking::where('end_time','>=',$before24hours)->where('status','6')->get();
        foreach($bookings as $booking)
        {
            $review=Review::where('sender_id',$booking->user_id)->where('booking_id',$booking->id)->where('user_id',$booking->business_id)->first();
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
        }
        //->update( array('status'=>'7'));
    }
}
