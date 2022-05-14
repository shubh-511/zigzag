<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Test;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing Cron Job';

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
        $test=Test::where('id','1')->increment('count');
        
        /*if($test>0)
        {
            $jsonArray['error']=false;
            $jsonArray['updated']="Updated";
        }
        else
        {
            $jsonArray['error']=false;
            $jsonArray['messaged']="Updated";
        }
        */
    }
}
