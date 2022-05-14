<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Subscription;


class AssignOrderToDriver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:driver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Driver assigned successfuly';

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
        $current_date = Carbon::now();
        
        $orders = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->leftJoin('stores', 'orders.store_id', '=', 'stores.id')
        ->select('orders.id as order_id',
        'orders.order_amount',
        'orders.order_status',
        'orders.order_type',
        'orders.from_pickup_address',
        'orders.to_pickup_address',
        'store_lat as from_lat',
        'store_lng as from_lng',
        'order_lat as to_lat',
        'order_lng as to_lng',
        'orders.delivery_charge',
        'orders.vehicle',
        'orders.billing_country',
        'stores.name as store_name',
        'stores.address as store_address')
        ->where('orders.status',1)
        ->where('orders.assign_driver_id',0)
        ->where('orders.order_status','<',2)
        ->where('orders.delivery_date_time','<=',$current_date)
        ->get();
        
        if(!empty($orders->toArray()))
        {
            foreach($orders as $order)
            {
                if(!empty($order->billing_country))
                {
                $dist=900000000000000000000000000;
                $mylat=$order->from_lat;
                $mylon=$order->from_lng;
                
                $lon1 = $mylon-$dist/abs(cos(deg2rad($mylat))*69);
                $lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
                
                $lat1 = $mylat-($dist/69);
                $lat2 = $mylat+($dist/69);
                
                $android_drivers = DB::select('SELECT u.id as driver_id,u.ongoing_status,u.device_type,u.device_token, 3956 2 ASIN(SQRT( POWER(SIN((u.cur_lat - ?) pi()/180 / 2), 2) +COS(u.cur_lat pi()/180) COS(? pi()/180) POWER(SIN((u.cur_lng -?) pi()/180 / 2), 2) )) as distance FROM users u where u.vehicle_type_id IN('.$order->vehicle.') and u.ready_for_pickup=1 and u.ongoing_status=0 and u.cur_lng between ? and ? and u.cur_lat between ? and ?',[$mylat,$mylat,$mylon,$lon1,$lon2,$lat1,$lat2]);
                
                    if(!empty($android_drivers))
                    {
                        foreach($android_drivers as $androiddrivers)
                        {
                            $fbn=new FirebaseNotification;
                            $fbn->receiver_id = $androiddrivers->driver_id;
                            $fbn->title="You have new delivery request";
                            $fbn->message="You have new delivery request";
                            $fbn->type=1;
                            $fbn->data_id=$order->order_id;
                            $fbn->pickup_lat=$order->from_lat;
                            $fbn->pickup_lng=$order->from_lng;
                            $fbn->drop_lat=$order->to_lat;
                            $fbn->drop_lng=$order->to_lng;
                            $fbn->order_type=$order->order_type;
                                if($order->order_type=='order')
                                {
                                    $fbn->from_pickup_address=$order->store_address;
                                }
                                else
                                {
                                    $fbn->from_pickup_address=$order->from_pickup_address;
                                }
                            $fbn->notification_id='0x001';
                            $fbn->save();
                            $this->NotifyDriver($androiddrivers->device_token,$fbn);
                        }
                    }
                }
            }
        }
    }
}
