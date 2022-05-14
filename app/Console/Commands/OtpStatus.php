<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Otp;

class OtpStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otp status changed';

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
    // After 48 hours Warranty will be expired automatically 
    
        $now= Carbon::now();
        $after2days=$now->addDays(-2);
        //Otp::where('created_at','>=',$now)->where('status','1')->update( array('status'=>'0'));
        Otp::where('status',1)->update(array('status'=>0));
    
    }
}
