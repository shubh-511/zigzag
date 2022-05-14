<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Page;
//use Twilio\Rest\Client;
use App\Country;
use App\State;
use App\OfferBanner;
use App\City;
use App\OrderDetail;
use App\Order;
use App\Payment;
use App\DeliveryCharge;
use Storage;
use App\RateDriver;
use App\Product;
use App\Cart;
use App\OrderCustomisation;
use App\Card;
use App\Contact;
use App\UserDocument;
use App\CartCustomisation;
use App\Customization;
use App\DishCustomisation;
use App\SiteSetting;
use App\FavouriteRestaurant;
use App\UserAddress;
use App\RateDish;
use App\Category;
use App\ProvidersMenus;
use App\RateProvider;
use App\Mail\Support;
use Validator;
use Mail;
use App\Otp;
use DB;
use Carbon\Carbon;
use App\Mail\SendEmail;
use App\Mail\ContactMail;


class ApisController extends Controller
{
 	protected $jsonArray=array();
 	private $fcm_key_user_android;
 	private $fcm_key_business_android;
 	private $fcm_key_user_ios;
 	private $fcm_key_business_ios;

    public function Intialize()
    {
/*           
        $fcm_key_user="AAAAIIGuKn8:APA91bGl8NBYcK0yg-CXpM9wQU-Dnfb_cVtjL6ARmPUcL-UMif3_ZZHigNfPWVZ27WriGs5MjUWDo5qQKv28DxnHDwzogAlyYAhMt-y2lk-8xcCM_fLC5xMy7Kol0ab3606qiM4rgmG9";
        $fcm_key_driver="AAAA2Gq2bLI:APA91bEqJdRsnK5ANzKOMeFeOw9G6Dd9sZPcqfqzvHoK1cLEsB-x-czAVW2-488INXxt1XgR3ZQgMihFN67PsIoIXQQTUVBHoM6XPl0WyVxJtIeaipe_EtQdL9NWmPFKOiPVPXYJHLxw";*/
    }

public function generate_token()
{
	$text="9568472130";     //80 characters
	return $text=substr(str_shuffle($text),0,6);
}	
    
  /* public function api_notification($token,$title) 
    {  
        
        $jsonArray['result']['title']=$title;
        
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAAf6oiMOg:APA91bG48XuG5TEWz0OkMw5c4utBf0LJBeB2lmjy6B9xify6zCEnfiixH8cVTSTd011jjyJgeaX-GSm56mI5I4iYQA0YjPX__VFdrEKo20SiHEixAMr_Iwr9ByhanDcLG_KIgYNh0jc6';
        $notification = array('title' =>$title , 'data' => $jsonArray, 'sound' => 'default', 'badge' =>'1');
        $arrayToSend = array('to' => $token, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                // 'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'data' => $jsonArray,
            ];
            
        $json = json_encode($arrayToSend);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result;
    } */
    
    public function distanceCalculation($lat1, $lon1, $lat2, $lon2, $unit='K') 
    {
          if (($lat1 == $lat2) && ($lon1 == $lon2)) 
          {
            return 0;
          }
          else 
          {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
        
            if ($unit == "K") {
              $mi = ($miles * 1.609344);
        	  return number_format($mi, 2, '.', '');
            } else if ($unit == "N") {
               $mi = ($miles * 0.8684);
        	 return number_format($mi, 2, '.', '');
            } else {
              return number_format($miles, 2, '.', '');
            }
          }
    }
    
    public function api_orderPlaceNotification($token,$title)
    {   
        $jsonArray['result']['title']=$title;
        $jsonArray['result']['order_status']=1;
        
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAAIIGuKn8:APA91bGl8NBYcK0yg-CXpM9wQU-Dnfb_cVtjL6ARmPUcL-UMif3_ZZHigNfPWVZ27WriGs5MjUWDo5qQKv28DxnHDwzogAlyYAhMt-y2lk-8xcCM_fLC5xMy7Kol0ab3606qiM4rgmG9';
        $notification = array('title' =>$title , 'sound' => 'default', 'badge' =>'1');
        //$arrayToSend = array('to' => $token, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                // 'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification'=>$notification,
                'priority'=>'high',
                'data' => $jsonArray,
            ];
            
        $json = json_encode($fcmNotification);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result; 
    }
    
    public function sendOrderCancelNotification($title,$token,$order)
    {
        $jsonArray['result']['title']=$title;
        $jsonArray['result']['order_status']=5;
        $jsonArray['result']['order_detail']=$order;
        
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAAIIGuKn8:APA91bGl8NBYcK0yg-CXpM9wQU-Dnfb_cVtjL6ARmPUcL-UMif3_ZZHigNfPWVZ27WriGs5MjUWDo5qQKv28DxnHDwzogAlyYAhMt-y2lk-8xcCM_fLC5xMy7Kol0ab3606qiM4rgmG9';
        $notification = array('title' =>$title , 'sound' => 'default', 'badge' =>'1');
        //$arrayToSend = array('to' => $token, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                // 'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification'=>$notification,
                'priority'=>'high',
                'data' => $jsonArray,
            ];
            
        $json = json_encode($fcmNotification);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result;
    }
    
    public function sendOrderAcceptNotification($title, $token, $order)
    {
        $jsonArray['result']['title']=$title;
        $jsonArray['result']['order_status']=2;
        $jsonArray['result']['order_detail']=$order;
        
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAAIIGuKn8:APA91bGl8NBYcK0yg-CXpM9wQU-Dnfb_cVtjL6ARmPUcL-UMif3_ZZHigNfPWVZ27WriGs5MjUWDo5qQKv28DxnHDwzogAlyYAhMt-y2lk-8xcCM_fLC5xMy7Kol0ab3606qiM4rgmG9';
        $notification = array('title' =>$title , 'sound' => 'default', 'badge' =>'1');
        //$arrayToSend = array('to' => $token, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                // 'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification'=>$notification,
                'priority'=>'high',
                'data' => $jsonArray,
            ];
            
        $json = json_encode($fcmNotification);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result;
    }
    
    public function sendOrderOutForDeliveryNotification($title, $token, $order)
    {
        $jsonArray['result']['title']=$title;
        $jsonArray['result']['order_status']=3;
        $jsonArray['result']['order_detail']=$order;
        
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAAIIGuKn8:APA91bGl8NBYcK0yg-CXpM9wQU-Dnfb_cVtjL6ARmPUcL-UMif3_ZZHigNfPWVZ27WriGs5MjUWDo5qQKv28DxnHDwzogAlyYAhMt-y2lk-8xcCM_fLC5xMy7Kol0ab3606qiM4rgmG9';
        $notification = array('title' =>$title , 'sound' => 'default', 'badge' =>'1');
        //$arrayToSend = array('to' => $token, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                // 'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification'=>$notification,
                'priority'=>'high',
                'data' => $jsonArray,
            ];
            
        $json = json_encode($fcmNotification);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result;
    }
    
    public function sendOrderDeliverNotification($title, $token, $order)
    {
        $jsonArray['result']['title']=$title;
        $jsonArray['result']['order_status']=4;
        $jsonArray['result']['order_detail']=$order;
        
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAAIIGuKn8:APA91bGl8NBYcK0yg-CXpM9wQU-Dnfb_cVtjL6ARmPUcL-UMif3_ZZHigNfPWVZ27WriGs5MjUWDo5qQKv28DxnHDwzogAlyYAhMt-y2lk-8xcCM_fLC5xMy7Kol0ab3606qiM4rgmG9';
        $notification = array('title' =>$title , 'sound' => 'default', 'badge' =>'1');
        //$arrayToSend = array('to' => $token, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                // 'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification'=>$notification,
                'priority'=>'high',
                'data' => $jsonArray,
            ];
            
        $json = json_encode($fcmNotification);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result;
    }
    
    /*public function sendOrderNotificationToDriver($title, $token, $order)
    {
        //$jsonArray['result']['title']=$title;
        //$jsonArray['result']['order_status']=1;
        //$jsonArray['result']['order_detail']=$order;
        
        $jsonArray['order_status']=1;
        $jsonArray['order_detail']=$order;
        
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAA2Gq2bLI:APA91bEqJdRsnK5ANzKOMeFeOw9G6Dd9sZPcqfqzvHoK1cLEsB-x-czAVW2-488INXxt1XgR3ZQgMihFN67PsIoIXQQTUVBHoM6XPl0WyVxJtIeaipe_EtQdL9NWmPFKOiPVPXYJHLxw';
        $notification = array('title' =>$title , 'data' => $jsonArray, 'sound' => 'default', 'badge' =>'1');
        $arrayToSend = array('to' => $token, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                // 'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'data' => $jsonArray,
            ];
            
        $json = json_encode($arrayToSend);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result;
    }*/
    
    public function sendOrderNotificationToDriver($title,$token,$order)
    {  
        
        $jsonArray['assigned_order']=$order;
        $jsonArray['result']['order_status']=1;
        $jsonArray['result']['title']=$title;
        $url = "https://fcm.googleapis.com/fcm/send";
       
        $notification = array('title' =>$title , 'sound' => 'default', 'badge' =>'1');
        
        $fcmNotification = [
                //'registration_ids' => $tokens, //multple token array
                'to'        => $token, //single token
                'notification'=>$notification,
                'priority'=>'high',
                'data' => $jsonArray,
            ];
            
        $json = json_encode($fcmNotification);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AAAA2Gq2bLI:APA91bEqJdRsnK5ANzKOMeFeOw9G6Dd9sZPcqfqzvHoK1cLEsB-x-czAVW2-488INXxt1XgR3ZQgMihFN67PsIoIXQQTUVBHoM6XPl0WyVxJtIeaipe_EtQdL9NWmPFKOiPVPXYJHLxw';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
       
        return $result;
       
    }
    

/*
|--------------------------------------------------------------------------
| API Login
| roles_id = 2 for user
| roles_id = 4 for driver
|--------------------------------------------------------------------------|
*/
public function api_login(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
			//'mobile' => 'required',
			'roles_id' => 'required',
			'device_type' => 'required',
			'device_token' => 'required',
		],
		[
			//'mobile.required' => 'Please enter mobile number',
			'roles_id.required' => 'Role id is missing',
			'device_type.required' => 'device type is missing',
			'device_token.required' => 'device token is missing'
			
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{	
		    if(!empty($request['mobile']))
		    {
    			$user = User::where('mobile',$request['mobile'])->where('roles_id',$request['roles_id'])->first();
    			if(!empty($user))
    			{
    			    if($user->status == 1)
    			    {
        				$user->device_type=$request['device_type'];
        				$user->device_token=$request['device_token'];
        				$user->otp = "1234"; //$this->generate_token();
        				$user->save();
        		        
        		        //$this->sendOTP($request['mobile'],$user->otp);
        		        
        		        $jsonArray['error'] = false;
                		$jsonArray['message'] = "Otp has been sent to your mobile";
        				$jsonArray['login_flag'] = 1; //for existing user
        				$jsonArray['result']=$user;
    			    }
    			    elseif($user->roles_id == 2 && $user->status == 0)
    			    {
    			        $jsonArray['error'] = true;
                		$jsonArray['message'] = "Your account has been suspended!";
    			    }
    			    elseif($user->roles_id == 4 && $user->admin_approval == 0)
    			    {
    			        $jsonArray['error'] = true;
                		$jsonArray['message'] = "Your account is pending for verification!";
    			    }
    			}		
    			else
    			{
    				$users=new User;
            	    $users->roles_id = $request['roles_id'];
            	    $users->mobile=$request['mobile'];
    				$users->otp = "1234";//$this->generate_token();
            	    $users->save();
            	    
            	    
            	     
            	   
            	    //$this->sendOTP($request['mobile'],$users->otp);
            	     
            	    $jsonArray['error']=false;
        	        $jsonArray['message']="Otp has been sent to your mobile";
    				$jsonArray['login_flag'] = 2; //for new user signup
        	        $jsonArray['result']=$users;
    			}
		    }
		    else
		    {
			    $jsonArray['error'] = false;
				//$jsonArray['message'] = "";
				$jsonArray['login_flag'] = 0;
				
		    }
		        
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
	return response()->json($jsonArray); 
}
	
public function sendOTP($mob,$otp)
{ 
    $account_sid = 'ACb599edb6610bae96239a7516105c6cf3';
    $auth_token = '60a99b037abd0c436b6c970714c29a26';
    $otp=$this->generate_token();
    $twilio_number = "+15673022791";
    $client = new Client($account_sid, $auth_token);
    $client->messages->create(
        // Where to send a text message (your cell phone?)
        '+919871094607',
        array(
            'from' => $twilio_number,
            'body' => 'Dear Customer, your OTP is : '.$otp.' Please do not share with anybody.'
        )
    );
// 	$apiKey = urlencode('');

// 	$numbers = array($mob);
// 	$sender = urlencode('TXTLCL');
// 	$mess = $otp.' is the OTP to login to your account. Do not share it with anyone.';
// 	$message = rawurlencode($mess);
 
// 	$numbers = implode(',', $numbers);
 
// 	// Prepare data for POST request
// 	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
// 	// Send the POST request with cURL
// 	$ch = curl_init('https://api.textlocal.in/send/');
// 	curl_setopt($ch, CURLOPT_POST, true);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 	$response = curl_exec($ch);
// 	curl_close($ch);
// 	return true; 
}


/*
|--------------------------------------------------------------------------
| API Verify Otp User
|--------------------------------------------------------------------------
*/

public function api_verify_otp(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'user_id' => 'required',
				'otp' => 'required',
				'roles_id' => 'required',
				'login_flag' => 'required',
				'device_type' => 'required',
				'device_token' => 'required'
			],
			[
				'user_id.required' => 'Please enter user id',
				'otp.required' => 'Please enter OTP',
				'roles_id.required' => 'Role id is missing',
				'login_flag.required' => 'Login flag is missing'
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
			//$mob = $request['mobile'];
			$users=User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->where('otp',$request['otp'])->first();
			if(!empty($users))
			{
				$users->otp = null;
				$users->save();
				
				//$this->sendOTP($mob,$send_otp->otp);
				User::where('id', $request['user_id'])->update(['device_type' => $request['device_type'], 'device_token' => $request['device_token']]);
				
				$jsonArray['error'] = false;
				if($request['login_flag'] ==1 )
				{
				    $jsonArray['message'] = "Login Successfully!";
				}
				else
				{
				    $jsonArray['message'] = "You have registered successfully!";
				}
				
				$jsonArray['login_flag'] = $request['login_flag'];
				
			}
			else
			{
				$jsonArray['error'] = true;
				$jsonArray['message'] = "Invalid OTP!"; 
			}
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Verify Otp Driver
|--------------------------------------------------------------------------
*/

public function api_verify_otpDriver(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'user_id' => 'required',
				'otp' => 'required',
				'roles_id' => 'required',
				'login_flag' => 'required',
				'device_type' => 'required',
				'device_token' => 'required'
			],
			[
				'user_id.required' => 'Please enter user id',
				'otp.required' => 'Please enter OTP',
				'roles_id.required' => 'Role id is missing',
				'login_flag.required' => 'Login flag is missing'
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
			//$mob = $request['mobile'];
			$users=User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->where('otp',$request['otp'])->first();
			if(!empty($users))
			{
				$users->otp = null;
				$users->save();
				
				//$this->sendOTP($mob,$send_otp->otp);
				$driverDoc = UserDocument::where('user_id', $request['user_id'])->first();
				
				if(!empty($driverDoc->driving_license_front) && !empty($driverDoc->driving_license_back) && !empty($driverDoc->id_card_front) && !empty($driverDoc->id_card_back)
				&& !empty($driverDoc->car_registration_front) && !empty($driverDoc->car_registration_back) && !empty($driverDoc->car_images_1) && !empty($driverDoc->car_images_2)
				&& !empty($driverDoc->car_images_3) && !empty($driverDoc->car_images_4) && !empty($driverDoc->non_criminal_rec_front) && !empty($driverDoc->non_criminal_rec_back)
				&& !empty($driverDoc->other_doc_1) && !empty($driverDoc->other_doc_2) && !empty($driverDoc->other_doc_3) && !empty($driverDoc->other_doc_4))
				{
				    if($users->admin_approval == 0)
				    {
				        $jsonArray['error'] = true;
    				    $jsonArray['message'] = "Your account is pending for approval!";
    				    //$jsonArray['profile_flag'] = 1;
				    }
    				elseif($request['login_flag'] ==1 )
    				{
    				    User::where('id', $request['user_id'])->update(['device_type' => $request['device_type'], 'device_token' => $request['device_token']]);
    				    $jsonArray['error'] = false;
    				    $jsonArray['message'] = "Login Successfully!";
    				    $jsonArray['profile_flag'] = 1;
    				    $jsonArray['documents'] = $driverDoc;
    				}
    				
				}
				else
				{
    				if($request['login_flag'] ==2)
    				{
    				    User::where('id', $request['user_id'])->update(['device_type' => $request['device_type'], 'device_token' => $request['device_token']]);
    				    $jsonArray['error'] = false;
    				    $jsonArray['message'] = "You have registered successfully!";
    				    $jsonArray['profile_flag'] = 0;
    				}
    				elseif($request['login_flag'] ==1 )
    				{
    				    User::where('id', $request['user_id'])->update(['device_type' => $request['device_type'], 'device_token' => $request['device_token']]);
    				    $jsonArray['error'] = false;
    				    $jsonArray['message'] = "Login Successfully!";
    				    $jsonArray['profile_flag'] = 0;
    				    $jsonArray['documents'] = $driverDoc;
    				}
				}
				
				
				
			}
			else
			{
				$jsonArray['error'] = true;
				$jsonArray['message'] = "Invalid OTP!"; 
			}
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Search Dishes or Restaurants
|--------------------------------------------------------------------------
*/	
public function api_search(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'keyword' => 'required',
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    $key = $request['keyword'];
		    
        	$dishes = Product::where('name', 'LIKE', "$key%")->orWhere('name', 'LIKE', "%$key")->orWhere('name', 'LIKE', "%$key%")->where('status',1)->orderBy('id','DESC')->get()->toArray();
        	$restros = User::where('roles_id',3)->where('status',1)->where('name', 'LIKE', "$key%")->orWhere('name', 'LIKE', "%$key")->orWhere('name', 'LIKE', "%$key%")->orderBy('id','DESC')->get()->toArray();
        	$result = array_merge($dishes,$restros);
    		$collectResult = collect($result);
        	
        	if(count($collectResult) > 0)
        	{
        	    $common = array();
        	    $rec5 = -1;
        		foreach($collectResult as $userLocation)
        		{
        		    if(!isset($userLocation['is_customisable']))
			        {
            			$rec5++;
            			$common[$rec5]['provider_or_product'] = 1;
            			$common[$rec5]['id'] = $userLocation['id'];
            			$common[$rec5]['name'] = $userLocation['name'];
            			$common[$rec5]['email'] = $userLocation['email'];
            			$common[$rec5]['mobile'] = $userLocation['mobile'];
            			
            			$common[$rec5]['user_image'] = $userLocation['user_image'];
            			$common[$rec5]['roles_id'] = $userLocation['roles_id'];
            			$common[$rec5]['lattitude'] = $userLocation['lattitude'];
            			$common[$rec5]['longitude'] = $userLocation['longitude'];
            		
                        $common[$rec5]['address'] = $userLocation['address'];
            			$common[$rec5]['country'] = $userLocation['country'];
            			$common[$rec5]['state'] = $userLocation['state'];
            			
            			$common[$rec5]['city'] = $userLocation['city'];
            			$common[$rec5]['zip'] = $userLocation['zip'];
            			$common[$rec5]['description'] = $userLocation['description'];
            			$common[$rec5]['delivery_available'] = $userLocation['delivery_available'];
			        }
			        else
			        {
			            $rec5++;
			            $common[$rec5]['provider_or_product'] = 2;
			            $common[$rec5]['id'] = $userLocation['id'];
            			$common[$rec5]['added_by'] = $userLocation['added_by'];
            			$common[$rec5]['product_cat_id'] = $userLocation['product_cat_id'];
            			$common[$rec5]['name'] = $userLocation['name'];
            			
            			$common[$rec5]['img'] = $userLocation['img'];
            			$common[$rec5]['description'] = $userLocation['description'];
            			$common[$rec5]['price'] = $userLocation['price'];
            			$common[$rec5]['is_customisable'] = $userLocation['is_customisable'];
			        }
        			
        		}
        		
            		$jsonArray['error'] = false;
            		$jsonArray['data'] = $common;
        		
        	}
        	else
        	{
        		$jsonArray['error'] = true;
        		$jsonArray['message'] = "No results found!";
        	}
            	
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Terms and Services User
|--------------------------------------------------------------------------
*/
public function api_pages()
{
    try
    {
        if(empty($_GET['page_id']))
        {
            $jsonArray['error']=true;
			$jsonArray['message']="Page ID is required";
        }
//          $validation = Validator::make($request->all(), 
//          [
//             'language'    => 'required',
//         ]);
//         if ($validation->fails()) 
//         {
// 			$jsonArray['error']=true;
// 			$jsonArray['message']=$validation->messages()->first();
//         }
        else
        {
            $page=Page::Where('id',$_GET['page_id'])->where('status','1')->first();
            
    		 return view('homepages.m_page_container')
            ->with('page',$page);  
            //->with('language',$request->language);
    	}
    }
    catch(Exception $e)
    {
        $jsonArray['error']=true;
        $jsonArray['message']=$e->getMessage();
    }
    
return response()->json($jsonArray); 

}

/*
|--------------------------------------------------------------------------
| API Update Profile User
|--------------------------------------------------------------------------
*/

public function api_update_profile(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'user_id' => 'required',
				'roles_id' => 'required',
				'name' => 'required',
				'dob' => 'required',
				'gender' => 'required',
				'email' => 'required|unique:users,email,'.$request['user_id'],
			],
			[
				'user_id.required' => 'Please enter user id',
				'roles_id.required' => 'Please enter roles id',
				'name.required' => 'Please enter name',
				'dob.required' => 'Please enter dob',
				'gender.required' => 'Please enter gender',
				'email.required' => 'Please enter email',
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
			$users=User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->first();
			if(!empty($users))
			{
			    if($request['gender'] == 1 )
			        $users->gender = 1; //male
			    elseif($request['gender'] == 2)
			        $users->gender = 2; //female
		        else
		            $users->gender = ''; 
			    
			    $target='siteimages/user/';
                $header_logo=$request->file('profile_image');
                if(!empty($header_logo))
                {
                    $headerImageName=$header_logo->getClientOriginalName();
                    $ext1=$header_logo->getClientOriginalExtension();
                    $temp1=explode(".",$headerImageName);
                    $newHeaderLogo='user'.rand()."".round(microtime(true)).".".end($temp1);
                    $headerTarget='siteimages/user/'.$newHeaderLogo;
                    $header_logo->move($target,$newHeaderLogo);
                    $users->user_image=$headerTarget;
                }
			    
				$users->name = $request['name'];
				$users->email = $request['email'];
				$users->dob = $request['dob'];
				$users->save();
				
				$userDtl = User::where('id', $request['user_id'])->first();
				
				$jsonArray['error'] = false;
				$jsonArray['message'] = "Your profile has been updated!";
				$jsonArray['data'] = $userDtl;
				
				
			}
			else
			{
				$jsonArray['error'] = true;
				$jsonArray['message'] = "There is some error while updating profile"; 
			}
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Get Profile
|--------------------------------------------------------------------------
*/

public function api_getProfile(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'user_id' => 'required',
				'roles_id' => 'required',
			],
			[
				'user_id.required' => 'Please enter user id',
				'roles_id.required' => 'Please enter roles id',
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
			$users=User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->first();
			if(!empty($users) && $request['roles_id'] == 2)
			{
				$jsonArray['error'] = false;
				$jsonArray['data'] = $users;
			}
			elseif(!empty($users) && $request['roles_id'] == 4)
			{
			    $approved = 0;
			    if($users->admin_approval == 1)
			    {
			        $approved = 1;
			    }
			    $orders = Order::whereDate('delivered_at', Carbon::today())->where('assign_driver_id',$request['user_id'])->where('order_status', 4)->get();
			    $ratings = RateDriver::where('driver_id', $request['user_id'])->avg('rating');
				$jsonArray['error'] = false;
				$jsonArray['todays_deliver_order'] = count($orders);
				$jsonArray['is_approved_by_admin'] = $approved;
				$jsonArray['avg_rating'] = number_format($ratings, 1, '.', '');
				$jsonArray['data'] = $users;
				
			}
			else
			{
				$jsonArray['error'] = true;
				$jsonArray['message'] = "Invalid user ID"; 
			}
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Get Providers list based on categories
|--------------------------------------------------------------------------
*/

public function api_getProvidersList(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'category_id' => 'required',
			],
			[
				'category_id.required' => 'Please select a category',
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    $common = array();
			$providers = User::whereRaw("find_in_set('$request[category_id]',category_ids)")->where('admin_approval', 1)->get();
			if(isset($providers) && count($providers) > 0)
			{
    			$r = -1;
    			foreach($providers as $nearByProvider)
    			{
    			    $r++;
    			    $ratings = RateProvider::where('provider_id', $nearByProvider['id'])->avg('rating');
    			    $startintAt = Product::where('added_by', $nearByProvider['id'])->get();
    			    
    			    $common[$r]['id'] = $nearByProvider['id'];
    			    $common[$r]['name'] = $nearByProvider['name'];
    			    $common[$r]['email'] = $nearByProvider['email'];
    			    $common[$r]['user_image'] = $nearByProvider['user_image'];
    			    $common[$r]['startint_at'] = $startintAt->min('price');
    			    $common[$r]['avg_rating'] = number_format($ratings, 1, '.', '');
    			    $common[$r]['roles_id'] = $nearByProvider['roles_id'];
    			    $common[$r]['lattitude'] = $nearByProvider['lattitude'];
    			    $common[$r]['longitude'] = $nearByProvider['longitude'];
    			    
    			}
    			$jsonArray['error']=false;
			    $jsonArray['data']=$common;
			}
			else
			{
				$jsonArray['error'] = true;
				$jsonArray['message'] = "No providers found solding products for this category"; 
			}
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Home Screen
|--------------------------------------------------------------------------|
*/
public function api_home_page(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'lattitude' => 'required',
			'longitude' => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles id',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    $simpleOffers = OfferBanner::where('type',1)->where('status',1)->get();
			$productCat = Category::where('status',1)->where('status',1)->get();
			$offers = OfferBanner::where('type',2)->where('status',1)->get();
			$floatingText = Sitesetting::where('id',1)->first();
			
			$common = array();
			$dist = 5;
    			$mylat=$request['lattitude'];
    			$mylon=$request['longitude'];
    			
    			$lon1 = $mylon-$dist/abs(cos(deg2rad($mylat))*69);
    			$lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
    
    			$lat1 = $mylat-($dist/69);
    			$lat2 = $mylat+($dist/69);
    			
    			$providersList = RateProvider::selectRaw("provider_id, avg( rating ) as avg_rating")
    			->groupBy('provider_id')
    			->orderBy('avg_rating','DESC')
    			->get();
    			//return $providersList;
    			
    			
    			$nearByProviders=User::selectRaw("id,name,email,user_image,roles_id,lattitude, longitude,
    			3956 * 2 * ASIN(SQRT( POWER(SIN((lattitude - '$mylat') *  pi()/180 / 2), 2) 
    			+COS(lattitude * pi()/180) * COS('$mylat' * pi()/180) * POWER(SIN((longitude -'$mylon') * pi()/180 / 2), 2) )) 
    			as distance")
    			->where('roles_id', 3)
    			->whereBetween('longitude', [$lon1,$lon2])
    			->whereBetween('lattitude', [$lat1,$lat2])
    			->get();
    			
    			
    			if(isset($nearByProviders) && count($nearByProviders) > 0)
    			{
        			$r = -1;
        			foreach($nearByProviders as $nearByProvider)
        			{
        			    $r++;
        			    $ratings = RateProvider::where('provider_id', $nearByProvider['id'])->avg('rating');
        			    
        			    $startintAt = Product::where('added_by', $nearByProvider['id'])->get();
        			    
        			    $common[$r]['id'] = $nearByProvider['id'];
        			    $common[$r]['name'] = $nearByProvider['name'];
        			    $common[$r]['email'] = $nearByProvider['email'];
        			    $common[$r]['user_image'] = $nearByProvider['user_image'];
        			    $common[$r]['avg_rating'] = number_format($ratings, 1, '.', '');
        			    $common[$r]['startint_at'] = $startintAt->min('price');
        			    $common[$r]['roles_id'] = $nearByProvider['roles_id'];
        			    $common[$r]['lattitude'] = $nearByProvider['lattitude'];
        			    $common[$r]['longitude'] = $nearByProvider['longitude'];
        			    $common[$r]['distance'] = number_format($nearByProvider['distance'], 2, '.', '');
        			}
    			}
			
		    if(!empty($request['user_id']))
		    {
		        User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->update(['lattitude' => $request['lattitude'], 'longitude' => $request['longitude']]);
    			$user = User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->first();
    			
    			$userCart = Cart::where('user_id', $request['user_id'])->first();
    			
		        $jsonArray['error'] = false;
		        if(isset($userCart) && !empty($userCart))
    			{
    			    $jsonArray['provider_id'] = $userCart->provider_id;
    			    $jsonArray['provider_name'] = $userCart->provider->name;
    			}
		        $jsonArray['floating_text'] = $floatingText->floating_text;
		        $jsonArray['user_data'] = $user;
				$jsonArray['banners'] = $simpleOffers;
				$jsonArray['categories'] = $productCat;
				$jsonArray['offers'] = $offers;
				$jsonArray['restaurants'] = $common;
		    }
		    else
		    {
			    $jsonArray['error'] = false;
			    $jsonArray['floating_text'] = $floatingText->floating_text;
				$jsonArray['banners'] = $simpleOffers;
				$jsonArray['categories'] = $productCat;
				$jsonArray['offers'] = $offers;
				$jsonArray['restaurants'] = $common;
				
		    }
		        
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
	return response()->json($jsonArray); 
}

/*
|--------------------------------------------------------------------------
| API View Restaurants on the basis of rating & sales
|--------------------------------------------------------------------------
*/

public function api_viewRestraurants(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'roles_id' => 'required',
				'restaurant_type' => 'required',
				'lattitude' => 'required',
			    'longitude' => 'required',
			],
			[
				'roles_id.required' => 'Role id is missing',
				'restaurant_type.required' => 'Please specify restaurant type'
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    
			$common = array();
			
    			
    			$providersList = RateProvider::selectRaw("provider_id, avg( rating ) as avg_rating")
    			->groupBy('provider_id')
    			->orderBy('avg_rating','DESC')
    			->get();
    			//return $providersList;
    			
    			$dist = 5;
    			$mylat=$request['lattitude'];
    			$mylon=$request['longitude'];
    			
    			$lon1 = $mylon-$dist/abs(cos(deg2rad($mylat))*69);
    			$lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
    
    			$lat1 = $mylat-($dist/69);
    			$lat2 = $mylat+($dist/69);
    			
    			if($request['restaurant_type'] == 1)
    			{
    			    $nearByProviders=User::selectRaw("id,name,email,user_image,roles_id,lattitude, longitude,
        			3956 * 2 * ASIN(SQRT( POWER(SIN((lattitude - '$mylat') *  pi()/180 / 2), 2) 
        			+COS(lattitude * pi()/180) * COS('$mylat' * pi()/180) * POWER(SIN((longitude -'$mylon') * pi()/180 / 2), 2) )) 
        			as distance")
        			->where('roles_id', 3)
        			->whereBetween('longitude', [$lon1,$lon2])
        			->whereBetween('lattitude', [$lat1,$lat2])
        			->get();
    			}
    			elseif($request['restaurant_type'] == 2)
    			{
    			    
    			}
    			elseif($request['restaurant_type'] == 3)
    			{
    			    //return $providersList->pluck('provider_id');
    			    $nearByProviders=User::selectRaw("id,name,email,user_image,roles_id,lattitude, longitude,
    			    3956 * 2 * ASIN(SQRT( POWER(SIN((lattitude - '$mylat') *  pi()/180 / 2), 2) 
        			+COS(lattitude * pi()/180) * COS('$mylat' * pi()/180) * POWER(SIN((longitude -'$mylon') * pi()/180 / 2), 2) )) 
        			as distance")
    			    ->whereIn('id', $providersList->pluck('provider_id'))
        			->where('roles_id', 3)
        			->get();
        			//dd($nearByProviders);
    			}
    			
    			
    			if(isset($nearByProviders) && count($nearByProviders) > 0)
    			{
        			$r = -1;
        			foreach($nearByProviders as $nearByProvider)
        			{
        			    $r++;
        			    $ratings = RateProvider::where('provider_id', $nearByProvider['id'])->avg('rating');
        			    $startintAt = Product::where('added_by', $nearByProvider['id'])->get();
        			    
        			    $common[$r]['id'] = $nearByProvider['id'];
        			    $common[$r]['name'] = $nearByProvider['name'];
        			    $common[$r]['email'] = $nearByProvider['email'];
        			    $common[$r]['user_image'] = $nearByProvider['user_image'];
        			    $common[$r]['startint_at'] = $startintAt->min('price');
        			    $common[$r]['avg_rating'] = number_format($ratings, 1, '.', '');
        			    $common[$r]['roles_id'] = $nearByProvider['roles_id'];
        			    $common[$r]['lattitude'] = $nearByProvider['lattitude'];
        			    $common[$r]['longitude'] = $nearByProvider['longitude'];
        			    $common[$r]['distance'] = number_format($nearByProvider['distance'], 2, '.', '');
        			}
    			}
			
		    
		    
			    $jsonArray['error'] = false;
				$jsonArray['restaurants'] = $common;
			
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Rate Restaurant
|--------------------------------------------------------------------------
*/
    public function api_rateRestaurant(Request $request)
    {
        try
    	{
    		$v = Validator::make($request->all(), [
    			'roles_id' => 'required',
    			'user_id' => 'required',
    			'provider_id' => 'required',
    			'rating' => 'required',
    		],
    		[
    			'roles_id.required' => 'Please enter roles id',
    		    'user_id.required' => 'You must login to rate this restaurant!',
    		    'provider_id.required' => 'Please specify Restaurant Id',
    		    'rating.required' => 'Please enter rating',
    		]);
    		if ($v->fails())
    		{
    			$jsonArray['error']=true;
    			$jsonArray['message']=$v->messages()->first();           
    		}
    		else 
    		{
                $user=User::where('id',$request['user_id'])->first();
                $providerId=User::where('id',$request['provider_id'])->first();
                
                $preRate = RateProvider::where('user_id', $request['user_id'])->where('provider_id', $request['provider_id'])->first();
                if(!empty($user) && !empty($providerId))
                {
                    if(count($preRate) == 0)
                    {
                        $rating = new RateProvider;
                        $rating->user_id=$request['user_id'];
                        $rating->provider_id=$request['provider_id'];
                        $rating->rating=$request['rating'];
                        $rating->save();
                        
                        $jsonArray['error']=false;
                        $jsonArray['message']="You have rated this restaurant";
                    }
                    else
                    {
                        RateProvider::where('user_id', $request['user_id'])->where('provider_id', $request['provider_id'])->update(['rating' => $request['rating']]);
                        $jsonArray['error']=false;
                        $jsonArray['message']="Your rating has been updated";
                    }
                }
                else 
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Invalid User Id or Provider ID";
                }
            }
    	}
        catch(Exception $e)
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']="Something Went Wrong!!!";
    	}    
        return response()->json($jsonArray);
    }
    
/*
|--------------------------------------------------------------------------
| API Make Favourite Restaurant
|--------------------------------------------------------------------------
*/
    public function api_makeFavourite_Restaurant(Request $request)
    {
        try
    	{
    		$v = Validator::make($request->all(), [
    			'roles_id' => 'required',
    			'user_id' => 'required',
    			'provider_id' => 'required',
    		],
    		[
    			'roles_id.required' => 'Please enter roles id',
    		    'user_id.required' => 'You must login to mark this restaurant to your favourite!',
    		    'provider_id.required' => 'Please specify Restaurant Id',
    		]);
    		if ($v->fails())
    		{
    			$jsonArray['error']=true;
    			$jsonArray['message']=$v->messages()->first();           
    		}
    		else 
    		{
                $user=User::where('id',$request['user_id'])->first();
                $providerId=User::where('id',$request['provider_id'])->first();
                
                $myFavRest = FavouriteRestaurant::where('user_id', $request['user_id'])->where('provider_id', $request['provider_id'])->first();
                if(!empty($user) && !empty($providerId))
                {
                    if(count($myFavRest) == 0)
                    {
                        $fav = new FavouriteRestaurant;
                        $fav->user_id=$request['user_id'];
                        $fav->provider_id=$request['provider_id'];
                        $fav->save();
                        
                        $jsonArray['error']=false;
                        $jsonArray['message']="You have mark this restaurant as your favourite";
                    }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['message']="This restaurant is already in your favourite list";
                    }
                }
                else 
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Invalid User Id or Provider ID";
                }
            }
    	}
        catch(Exception $e)
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']="Something Went Wrong!!!";
    	}    
        return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Remove Favourite Restaurant
|--------------------------------------------------------------------------
*/
    public function api_removeFavourite_Restaurant(Request $request)
    {
        try
    	{
    		$v = Validator::make($request->all(), [
    			'roles_id' => 'required',
    			'user_id' => 'required',
    			'provider_id' => 'required',
    		],
    		[
    			'roles_id.required' => 'Please enter roles id',
    		    'user_id.required' => 'You must login to remove this restaurant from your favourite!',
    		    'provider_id.required' => 'Please specify Restaurant Id',
    		]);
    		if ($v->fails())
    		{
    			$jsonArray['error']=true;
    			$jsonArray['message']=$v->messages()->first();           
    		}
    		else 
    		{
                $user=User::where('id',$request['user_id'])->first();
                $providerId=User::where('id',$request['provider_id'])->first();
                
                $myFavRest = FavouriteRestaurant::where('user_id', $request['user_id'])->where('provider_id', $request['provider_id'])->first();
                if(!empty($user) && !empty($providerId))
                {
                    $fav = FavouriteRestaurant::where('user_id', $request['user_id'])->where('provider_id', $request['provider_id'])->delete();
                    if($fav == 1)
                    {   
                        $jsonArray['error']=false;
                        $jsonArray['message']="You have removed this provider from your favourite list";
                    }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['message']="You have not make this provider as your favourite";
                    }
                }
                else 
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Invalid User Id or Provider ID";
                }
            }
    	}
        catch(Exception $e)
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']="Something Went Wrong!!!";
    	}    
        return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Get Alert when adding product of different providers
|--------------------------------------------------------------------------
*/
public function api_getAlertFromDifferentProviders(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
		    'roles_id' => 'required',
			'user_id' => 'required',
		],
		[
		    'roles_id.required' => 'Roles ID is missing',
			'user_id.required' => 'Please enter a user id',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    $tempArr = array();
		    $user = User::where('id',$request['user_id'])->first();
	        if(!empty($user))
	        {
	            $userCartCounts = Cart::where('user_id',$request['user_id'])->get();
	            
                if((!empty($userCartCounts) && count($userCartCounts) > 0))
                {
	                foreach($userCartCounts as $userCartCount)
	                {
	                    array_push($tempArr, $userCartCount->id);
	                }
	                
    	                CartCustomisation::whereIn('cart_id', $tempArr)->delete();
    	                Cart::where('user_id', $request['user_id'])->delete();
    	            
                    $jsonArray['error']=false;
                    $jsonArray['message']="Previous cart items has been removed from your cart!";
                }
                else
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Your cart currently have no items!";
                }
	        }
	        else
	        {
	            $jsonArray['error']=true;
                $jsonArray['message']="User Id is invalid!";
	        }
		   
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Get Favourite Restaurant List
|--------------------------------------------------------------------------
*/
public function api_getFavouriteRestaurants(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
		    'roles_id' => 'required',
			'user_id' => 'required',
		],
		[
		    'roles_id.required' => 'Roles ID is missing',
			'user_id.required' => 'Please enter a user id',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
            $favRest=FavouriteRestaurant::with('providers')->where('user_id',$request['user_id'])->get();
    
            if(count($favRest) > 0)
            {
                $common = array();
                $r=-1;
                foreach($favRest as $customisation)
                {
                    $r++;
                    $ratings = RateProvider::where('provider_id', $customisation->provider_id)->avg('rating');
        			$startintAt = Product::where('added_by', $customisation->provider_id)->get();
                    
                    $common[$r]['id'] = $customisation->id;
                    $common[$r]['provider_id'] = $customisation->provider_id;
                    $common[$r]['name'] = $customisation->providers->name;
                    $common[$r]['user_image'] = $customisation->providers->user_image;
                    $common[$r]['avg_rating'] = number_format($ratings, 1, '.', '');
                    $common[$r]['startint_at'] = $startintAt->min('price');
                   
                    
                    $jsonArray['error']=false;
                    $jsonArray['count']=count($favRest);
                    $jsonArray['providers']=$common;
                    
                }
                
		    }   
		    else
		    {
		        $jsonArray['error']=true;
                $jsonArray['message']="No favourite list found!";
		    }
             
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}
    
/*
|--------------------------------------------------------------------------
| API Rate a Dish
|--------------------------------------------------------------------------
*/
    public function api_rateDish(Request $request)
    {
        try
    	{
    		$v = Validator::make($request->all(), [
    			'roles_id' => 'required',
    			'user_id' => 'required',
    			'dish_id' => 'required',
    			'rating' => 'required',
    		],
    		[
    			'roles_id.required' => 'Please enter roles id',
    		    'user_id.required' => 'You must login to rate this dish!',
    		    'dish_id.required' => 'Please specify Dish Id',
    		    'rating.required' => 'Please enter rating',
    		]);
    		if ($v->fails())
    		{
    			$jsonArray['error']=true;
    			$jsonArray['message']=$v->messages()->first();           
    		}
    		else 
    		{
                $user=User::where('id',$request['user_id'])->first();
                $dishID=Product::where('id',$request['dish_id'])->first();
                
                $rateDish = RateDish::where('user_id', $request['user_id'])->where('dish_id', $request['dish_id'])->first();
                if(!empty($user) && !empty($dishID))
                {
                    if(count($rateDish) == 0)
                    {
                        $rating = new RateDish;
                        $rating->user_id=$request['user_id'];
                        $rating->dish_id=$request['dish_id'];
                        $rating->rating=$request['rating'];
                        $rating->save();
                        
                        $jsonArray['error']=false;
                        $jsonArray['message']="You have rated this dish";
                    }
                    else
                    {
                        RateDish::where('user_id', $request['user_id'])->where('dish_id', $request['dish_id'])->update(['rating' => $request['rating']]);
                        $jsonArray['error']=false;
                        $jsonArray['message']="Your rating has been updated";
                    }
                }
                else 
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Invalid User Id or Dish ID";
                }
            }
    	}
        catch(Exception $e)
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']="Something Went Wrong!!!";
    	}    
        return response()->json($jsonArray);
    }    

/*
|--------------------------------------------------------------------------
| API Restaurant Detail
|--------------------------------------------------------------------------
*/
    public function api_RestaurantDetail(Request $request)
    {
        try
    	{
    		$v = Validator::make($request->all(), [
    			'roles_id' => 'required',
    			//'user_id' => 'required',
    			'provider_id' => 'required',
    		],
    		[
    			'roles_id.required' => 'Please enter roles id',
    		    //'user_id.required' => 'Please specify User Id',
    		    'provider_id.required' => 'Please specify Restaurant Id',
    		]);
    		if ($v->fails())
    		{
    			$jsonArray['error']=true;
    			$jsonArray['message']=$v->messages()->first();           
    		}
    		else 
    		{
                $providerId=User::select(['id','name','user_image','description','lattitude','longitude'])->where('id',$request['provider_id'])->first();
                $ratings = RateProvider::where('provider_id', $request['provider_id'])->avg('rating');
                $providerMenu = ProvidersMenus::where('user_id', $request['provider_id'])->get();
                
                
                if(empty($request['user_id']))
                {
                    if(!empty($providerId))
                    {
                        $jsonArray['error']=false;
                        $jsonArray['message']="Restaurant Detail";
                        $jsonArray['rating']=number_format($ratings, 1, '.', '');
                        $jsonArray['restaurant']=$providerId;
                        $jsonArray['menus']=$providerMenu;
                    }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['message']="Invalid Provider ID";
                    }
                    
                }
                else
                {
                    $user=User::where('id',$request['user_id'])->first();
                    if(!empty($user) && !empty($providerId))
                    {
                        $myFavRest = FavouriteRestaurant::where('user_id', $request['user_id'])->where('provider_id', $request['provider_id'])->first();
        		        if(isset($myFavRest))
        		        {
        		            $fav = 1;
        		        }
        		        else
        		        {
        		            $fav = 0;
        		        }
                        $jsonArray['error']=false;
                        $jsonArray['message']="Restaurant Detail";
                        $jsonArray['fav_key']=$fav;
                        $jsonArray['rating']=number_format($ratings, 1, '.', '');
                        $jsonArray['restaurant']=$providerId;
                        $jsonArray['menus']=$providerMenu;
                        
                    }
                    else 
                    {
                        $jsonArray['error']=true;
                        $jsonArray['message']="Invalid User Id or Provider ID";
                    }
                }
            }
    	}
        catch(Exception $e)
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']="Something Went Wrong!!!";
    	}    
        return response()->json($jsonArray);
    }
    
    
/*
|--------------------------------------------------------------------------
| API View Restaurants detail on the basis of rating & bussiness details
|--------------------------------------------------------------------------
*/
public function api_Restraurant_detail(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'roles_id' => 'required',
				'provider_id' => 'required',
				'tab' => 'required',
			],
			[
				'roles_id.required' => 'Role id is missing',
				'provider_id.required' => 'Please specify provider ID',
				'tab.required' => 'Please select the tab'
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    if(!empty($request['user_id']))
		    {
		        $cartCounts = Cart::where('user_id', $request['user_id'])->get();
		        $cnts = count($cartCounts);
		        $price = Cart::where('user_id', $request['user_id'])->sum('amount');
		        $priceCounts = $price;
		        
		        $myFavRest = FavouriteRestaurant::where('user_id', $request['user_id'])->where('provider_id', $request['provider_id'])->first();
		        if(isset($myFavRest))
		        {
		            $fav = 1;
		        }
		        else
		        {
		            $fav = 0;
		        }
		    }
		    else
		    {
		        $cnts = 0;
		        $priceCounts = 0;
		        $fav = 0;
		    }
		    $provider = $request['provider_id'];
		    $providerId=User::select(['id','name','user_image','description','lattitude','longitude'])->where('id',$request['provider_id'])->first();
            
            if(count($providerId) > 0)
            { 
                if($request['tab'] == 1)
                {
                    $providerMenu = ProvidersMenus::where('user_id', $request['provider_id'])->where('status',1)->get();
                    if(count($providerMenu) > 0)
                    {
                        $jsonArray['error']=false;
                        $jsonArray['cart_counts']=$cnts;
                        $jsonArray['cart_price_counts']=$priceCounts;
                        $jsonArray['fav_key']=$fav;
                        $jsonArray['data']=$providerMenu;
                    }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['cart_counts']=$cnts;
                        $jsonArray['cart_price_counts']=$priceCounts;
                        $jsonArray['fav_key']=$fav;
                        $jsonArray['message']="No menus found!";
                    }
                }
                elseif($request['tab'] == 2)
                {
        //             $ratings = RateDish::with(['dish' => function($query) use($request) {
        //                 $query->where('added_by', $request['provider_id']);
        //             }])
        //             ->selectRaw("dish_id, avg( rating ) as avg_rating")
        // 			->groupBy('dish_id')
        // 			->orderBy('avg_rating','DESC')
        // 			->get();
        			
        			$ratings = RateDish::selectRaw("dish_id, avg( rating ) as avg_rating")
        			->groupBy('dish_id')
        			->orderBy('avg_rating','DESC')
        			->get();
        			
        			$common = array();
        			$r = -1;
        			
        			foreach($ratings as $rating)
        			{
        			    $prCnt = Product::where('id', $rating->dish_id)->where('added_by', $request['provider_id'])->first();
        		        $dishCustom = DishCustomisation::where('product_id', $rating->dish_id)->get();
        			    if(count($prCnt) > 0)
        			    {
            			    $r++;
            			    //$common[$r]['dish_id'] = $rating->dish_id;
            			    
            			    $common[$r]['id'] = $prCnt->id;
            			    $common[$r]['added_by'] = $prCnt->added_by;
            			    $common[$r]['product_cat_id'] = $prCnt->product_cat_id;
            			    $common[$r]['name'] = $prCnt->name;
            			    $common[$r]['img'] = $prCnt->img;
            			    $common[$r]['description'] = $prCnt->description;
            			    $common[$r]['price'] = $prCnt->price;
            			    $common[$r]['is_customisable'] = $prCnt->is_customisable;
            			    $common[$r]['status'] = $prCnt->status;
            			    $common[$r]['avg_rating'] = $rating->avg_rating;
            			    if(!empty($request['user_id']))
                            {
                                $cartDish = Cart::where('user_id', $request['user_id'])->where('dish_id', $prCnt->id)->first();
                                if(count($cartDish) > 0)
                                {
                                    $common[$r]['is_addedToCart'] = 1;
                                    $common[$r]['quantity_added'] = $cartDish->quantity;
                                    $common[$r]['total_price'] = $cartDish->amount;
                                }
                                else
                                {
                                    $common[$r]['is_addedToCart'] = 0;
                                    $common[$r]['quantity_added'] = 0;
                                    $common[$r]['total_price'] = 0;
                                }
                            }
            			    $common[$r]['created_at'] = $prCnt->created_at;
            			    $common[$r]['updated_at'] = $prCnt->updated_at;
            			    $common[$r]['customization'] = $dishCustom;
            			    
        			    }
        			}
        			
                    $dishes = Product::where('added_by', $request['provider_id'])->get();
                    
                    
                    if(count($common) > 0)
                    {
                        $jsonArray['error']=false;
                        $jsonArray['cart_counts']=$cnts;
                        $jsonArray['cart_price_counts']=$priceCounts;
                        $jsonArray['fav_key']=$fav;
                        $jsonArray['dishes']=$common;
                    }
                    // elseif(count($dishes) > 0)
                    // {
                    //     $jsonArray['error']=false;
                    //     $jsonArray['data']=$dishes;
                    // }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['cart_counts']=$cnts;
                        $jsonArray['cart_price_counts']=$priceCounts;
                        $jsonArray['fav_key']=$fav;
                        $jsonArray['message']="Sorry, currently no dishes found by rating";
                    }
                }
                elseif($request['tab'] == 3)
                {
                    $providerDetail=User::select(['id','name','user_image','description','lattitude','longitude'])->where('id',$request['provider_id'])->first();
                    if(count($providerDetail) > 0)
                    {
                        $jsonArray['error']=false;
                        $jsonArray['cart_counts']=$cnts;
                        $jsonArray['cart_price_counts']=$priceCounts;
                        $jsonArray['fav_key']=$fav;
                        $jsonArray['data']=$providerDetail;
                    }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['cart_counts']=$cnts;
                        $jsonArray['cart_price_counts']=$priceCounts;
                        $jsonArray['fav_key']=$fav;
                        $jsonArray['message']="No information found!";
                    }
                }
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="Invalid Provider ID";
            }
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
	
return response()->json($jsonArray);

}   


/*
|--------------------------------------------------------------------------
| API Get Menu Dishes
|--------------------------------------------------------------------------
*/
public function api_getMenuDishes(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'provider_id' => 'required',
			'menu_id' => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles id',
			'provider_id.required' => 'Please select a restaurant',
		    'menu_id.required' => 'Please select a menu',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    if(!empty($request['user_id']))
		    {
		        $cartCounts = Cart::where('user_id', $request['user_id'])->get();
		        $cnts = count($cartCounts);
		        $price = Cart::where('user_id', $request['user_id'])->sum('amount');
		        $priceCounts = $price;
		    }
		    else
		    {
		        $cnts = 0;
		        $priceCounts = 0;
		    }
		    
            $menu=ProvidersMenus::where('id',$request['menu_id'])->where('user_id',$request['provider_id'])->first();
            $menuDishes = Product::where('product_cat_id', $request['menu_id'])->where('added_by', $request['provider_id'])->get();
            $common = array();
            $r = -1;
            if(count($menuDishes) > 0)
            {
                foreach($menuDishes as $menuDish)
                {
                    $r++;
                    $ratings = RateDish::where('dish_id', $menuDish->id)->avg('rating');
                    $dishCustom = DishCustomisation::where('product_id', $menuDish->id)->get();
                    $common[$r]['id'] = $menuDish->id;
                    $common[$r]['added_by'] = $menuDish->added_by;
                    $common[$r]['product_cat_id'] = $menuDish->product_cat_id;
                    $common[$r]['name'] = $menuDish->name;
                    $common[$r]['img'] = $menuDish->img;
                    $common[$r]['avg_rating'] = number_format($ratings, 1, '.', '');
                    $common[$r]['description'] = $menuDish->description;
                    $common[$r]['price'] = $menuDish->price;
                    $common[$r]['is_customisable'] = $menuDish->is_customisable;
                    $common[$r]['status'] = $menuDish->status;
                    $common[$r]['created_at'] = $menuDish->created_at;
                    $common[$r]['updated_at'] = $menuDish->updated_at;
                    $common[$r]['customization'] = $dishCustom;
                    if(!empty($request['user_id']))
                    {
                        $cartDish = Cart::where('user_id', $request['user_id'])->where('dish_id', $menuDish->id)->first();
                        if(count($cartDish) > 0)
                        {
                            $common[$r]['is_addedToCart'] = 1;
                            $common[$r]['quantity_added'] = $cartDish->quantity;
                            $common[$r]['total_price'] = $cartDish->amount;
                        }
                        else
                        {
                            $common[$r]['is_addedToCart'] = 0;
                            $common[$r]['quantity_added'] = 0;
                            $common[$r]['total_price'] = 0;
                        }
                    }
                    
                }
                
                
                $jsonArray['error']=false;
                $jsonArray['message']="Menu Dishes";
                $jsonArray['cart_counts']=$cnts;
                $jsonArray['cart_price_counts']=$priceCounts;
                $jsonArray['menu_detail']=$menu;
                $jsonArray['dishes']=$common;
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="Sorry, currently no dishes found for this menu";
            }
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Dish Detail
|--------------------------------------------------------------------------
*/
public function api_DishDetail(Request $request)
{
    $common = array();
    try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'dish_id' => 'required',
			'provider_id' => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles id',
		    'dish_id.required' => 'Please specify Dish Id',
		    'provider_id.required' => 'Please specify provider Id',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    
		    //->with(array('user'=>function($query){$query->select('id');}))
            $dish=Product::where('id',$request['dish_id'])->first();
            $customisations = Customization::where('provider_id', $request['provider_id'])->get();
            
            
            $r=-1;
            foreach($customisations as $customisation)
            {
                $dishCustom = DishCustomisation::where('product_id', $request['dish_id'])->where('cutomisation', $customisation->id)->get();
                if(count($dishCustom) > 0)
                {   
                    $r++;
                    $common[$r]['id'] = $customisation->id;
                    $common[$r]['provider_id'] = $customisation->provider_id;
                    $common[$r]['name'] = $customisation->name;
                    $common[$r]['status'] = $customisation->status;
                    $common[$r]['all_sub_types'] = $dishCustom;
                }
            }
            
            if(!empty($dish))
            {
                $jsonArray['error']=false;
                $jsonArray['message']="Product Detail";
                $jsonArray['dish']=$dish;
                $jsonArray['customization']=$common;
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="No Dish found with this ID";
            }
              
        }
    	}
        catch(Exception $e)
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']="Something Went Wrong!!!";
    	}    
    return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Add Dish To Cart
|--------------------------------------------------------------------------
*/
public function api_addToCart(Request $request)
{
    try
    {
    	$v = Validator::make($request->all(), [
    		'roles_id' => 'required',
    		'user_id' => 'required',
    		'dish_id' => 'required',
    		'quantity' => 'required',
    		'amount' => 'required',
    		'provider_id' => 'required',
    		'is_customizable' => 'required',
    	],
    	[
    		'roles_id.required' => 'Please enter roles id',
    		'user_id.required' => 'Please enter a user id',
    	    'dish_id.required' => 'Please select a dish',
    	    'quantity.required' => 'Please enter quantity',
    	    'amount.required' => 'Please enter amount',
    	    'provider_id.required' => 'The provider ID is missing',
    	    'is_customizable.required' => 'Please select if you want to customize',
    	]);
    	if ($v->fails())
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$v->messages()->first();           
    	}
    	else 
    	{
    	    $userDetail = User::where('id', $request['user_id'])->first();
    	    $dishDetail = Product::where('id', $request['dish_id'])->first();
    	    
    	    if(!empty($userDetail) && !empty($dishDetail))
    	    {
        	        $cart = new Cart;
                    $cart->user_id=$request['user_id'];
                    $cart->provider_id=$request['provider_id'];
                    $cart->dish_id=$request['dish_id'];
                    $cart->amount=$request['amount'];
                    $cart->quantity=1;
                    $cart->product_img=$dishDetail->img;
                    $cart->product_name=$dishDetail->name;
                    $cart->product_price=$dishDetail->price;
                        if($request['is_customizable'] == 1)
                        {
                            $cart->is_customizable=1;
                        }
                        else
                        {
                            $cart->is_customizable=0;
                        }
                    $cart->save();
                    
                        if($request['is_customizable'] == 1)
                        {
                            
                            $all_customisations = explode(",",$request['customisations']);
                            $tcustomisations = count($all_customisations);
                            
                            $all_subtypes = explode(",",$request['sub_types']);
                            $tsubtypes = count($all_subtypes);
                            
                            
                            foreach($all_customisations as $key => $question)
                            {
				
                				foreach($all_subtypes as $ans)
                				{
                				
                					$qans = explode("@",$all_subtypes[$key]);
                				
                    				foreach($qans as $quans)
                    				{
                    				    $customisations = Customization::where('id', $question)->first();
                    				    $dishCust = DishCustomisation::where('id', $quans)->first();
                    				    
                    				    $cartAttr = new CartCustomisation;
                                        $cartAttr->cart_id = $cart->id;
                                        
                                        $cartAttr->customisation_id = $question;
                                        $cartAttr->subtypes_id = $quans;
                                        
                                        $cartAttr->customisation = $customisations->name;
                                        $cartAttr->subtypes = $dishCust->type;
                                        $cartAttr->prices = $dishCust->prices;
                                        $cartAttr->save();
                    				}
                				
                				break; 
                				
                				}
            				
            			    }
                            
                        }
                    
                    $jsonArray['error']=false;
                    $jsonArray['message']="Added to your cart!";
                    $jsonArray['data']=$cart;
        	    //}
    	    }
    	    else
    	    {
    	        $jsonArray['error']=true;
                $jsonArray['message']="Invalid user or dish ID";
    	    }
            
        }
    }
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);

}

/*
|--------------------------------------------------------------------------
| API Get User Cart Customise Items
|--------------------------------------------------------------------------
*/
public function api_getCartCustomiseItems(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
			'user_id' => 'required',
			'dish_id' => 'required',
			'roles_id' => 'required',
		],
		[
			'user_id.required' => 'Please enter a user ID',
		    'dish_id.required' => 'Please enter a dish ID',
		    'roles_id.required' => 'Please enter roles id',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
            $userCartItems=Cart::where('user_id',$request['user_id'])->where('dish_id',$request['dish_id'])->get();
            
            $common = array();
            $r = -1;
            if(count($userCartItems) > 0)
            {
                foreach($userCartItems as $userCartItem)
                {
                    $r++;
                    
                    $userCartCustomiseItems=CartCustomisation::where('cart_id',$userCartItem->id)->get();
                    $common[$r]['id'] = $userCartItem->id;
                    $common[$r]['user_id'] = $userCartItem->user_id;
                    $common[$r]['provider_id'] = $userCartItem->provider_id;
                    $common[$r]['dish_id'] = $userCartItem->dish_id;
                    $common[$r]['quantity'] = $userCartItem->quantity;
                    $common[$r]['amount'] = $userCartItem->amount;
                    $common[$r]['product_img'] = $userCartItem->product_img;
                    $common[$r]['product_name'] = $userCartItem->product_name;
                    $common[$r]['product_price'] = $userCartItem->product_price;
                    $common[$r]['is_customizable'] = $userCartItem->is_customizable;
                    $common[$r]['created_at'] = $userCartItem->created_at;
                    $common[$r]['updated_at'] = $userCartItem->updated_at;
                    $common[$r]['customization'] = $userCartCustomiseItems;
                }
                
                
                $jsonArray['error']=false;
                $jsonArray['data']=$common;
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="You have not added any items to your cart!";
            }
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Update Cart
|--------------------------------------------------------------------------
*/
public function api_updateCart(Request $request)
{
    try
    {
    	$v = Validator::make($request->all(), [
    		'roles_id' => 'required',
    		'dish_id' => 'required',
    		'user_id' => 'required',
    		'amount' => 'required',
    		'quantity' => 'required',
    		//'is_customizable' => 'required',
    	],
    	[
    		'roles_id.required' => 'Please enter roles id',
    		'dish_id.required' => 'Please enter a dish id',
    		'user_id.required' => 'Please enter a user id',
    	    //'is_customizable.required' => 'Please select if you want to customize',
    	]);
    	if ($v->fails())
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$v->messages()->first();           
    	}
    	else 
    	{
    	    $userCart = Cart::where('dish_id', $request['dish_id'])->where('user_id', $request['user_id'])->first();
    	    if(count($userCart) > 0)
    	    {
    	        if($request['quantity'] == 0)
    	        {
    	            CartCustomisation::where('cart_id', $userCart->id)->delete();
    	            Cart::where('dish_id', $request['dish_id'])->where('user_id', $request['user_id'])->delete();
    	            
            		$jsonArray['error']=false;
            		$jsonArray['message']="Dish has been removed from your cart!";    	            
    	        }
    	        else
    	        {
                    $userCart->amount=$request['amount'];
                    $userCart->quantity=$request['quantity'];
                    $userCart->save();
                //         if($request['is_customizable'] == 1)
                //         {
                //             $userCart->is_customizable=1;
                //         }
                //         else
                //         {
                //             $userCart->is_customizable=0;
                //         }
                    
                    
                //         if($request['is_customizable'] == 1)
                //         {
                //             CartCustomisation::where('cart_id', $request['cart_id'])->delete();
                //             $all_customisations = explode(",",$request['customisations']);
                //             $tcustomisations = count($all_customisations);
                            
                //             $all_subtypes = explode(",",$request['sub_types']);
                //             $tsubtypes = count($all_subtypes);
                            
                            
                //             foreach($all_customisations as $key => $question)
                //             {
				
                // 				foreach($all_subtypes as $ans)
                // 				{
                				
                // 					$qans = explode("@",$all_subtypes[$key]);
                				
                //     				foreach($qans as $quans)
                //     				{
                //     				    $customisations = Customization::where('id', $question)->first();
                //     				    $dishCust = DishCustomisation::where('id', $quans)->first();
                    				    
                //     				    $cartAttr = new CartCustomisation;
                //                         $cartAttr->cart_id = $cart->id;
                                        
                //                         $cartAttr->customisation_id = $question;
                //                         $cartAttr->subtypes_id = $quans;
                                        
                //                         $cartAttr->customisation = $customisations->name;
                //                         $cartAttr->subtypes = $dishCust->type;
                //                         $cartAttr->prices = $dishCust->prices;
                //                         $cartAttr->save();
                //     				}
                				
                // 				break; 
                				
                // 				}
            				
            			 //   }
                            
                //         }
                //         else
                //         {
                //             CartCustomisation::where('cart_id', $request['cart_id'])->delete();
                //         }
                    
                    
                    $finaluserCart = Cart::where('dish_id', $request['dish_id'])->where('user_id', $request['user_id'])->first();
                    
                    $jsonArray['error']=false;
                    $jsonArray['message']="Cart updated!";
                    $jsonArray['data']=$finaluserCart;
    	        }
    	    }
    	    else
    	    {
    	        $jsonArray['error']=true;
                $jsonArray['message']="You have not added this dish in your cart!";
    	    }
            
        }
    }
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);

}

/*
|--------------------------------------------------------------------------
| API Get Cart Items
|--------------------------------------------------------------------------
*/
public function api_getCartItems(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'user_id' => 'required',
			'provider_id' => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles ID',
		    'user_id.required' => 'Please select a user ID!',
		    'provider_id.required' => 'Provider Id is missing!',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
            $userCart=Cart::where('user_id',$request['user_id'])->get();
        
            if(count($userCart) > 0)
            {
                $common = array();
                $r=-1;
                foreach($userCart as $customisation)
                {
                    $r++;
                    $cartCust = CartCustomisation::where('cart_id', $customisation->id)->get();
                    
                    $common[$r]['id'] = $customisation->id;
                    $common[$r]['provider_id'] = $customisation->provider_id;
                    $common[$r]['user_id'] = $customisation->user_id;
                    $common[$r]['dish_id'] = $customisation->dish_id;
                    $common[$r]['quantity'] = $customisation->quantity;
                    $common[$r]['amount'] = $customisation->amount;
                    $common[$r]['product_img'] = $customisation->product_img;
                    $common[$r]['product_name'] = $customisation->product_name;
                    $common[$r]['product_price'] = $customisation->product_price;
                    $common[$r]['description'] = $customisation->description;
                    $common[$r]['is_customizable'] = $customisation->is_customizable;
                    $common[$r]['selected_customisations'] = $cartCust;
                    
                    
                }
                    $userDetails = User::where('id', $request['user_id'])->first();
                    $providerDetails = User::where('id', $request['provider_id'])->first();
                    if(!empty($providerDetails->lattitude) && !empty($providerDetails->longitude) && !empty($userDetails->lattitude) && !empty($userDetails->longitude))
                    {
                        $distance = $this->distanceCalculation($providerDetails->lattitude, $providerDetails->longitude, $userDetails->lattitude, $userDetails->longitude);
                    }
                    else
                    {
                        $distance = 99999;
                    }
                    
                    $deliveryCharges = DeliveryCharge::where('from_distance','<=',$distance)->Where('to_distance','>=',$distance)->where('status',1)->first();
                    
                    
                    
                    $jsonArray['error']=false;
                    $jsonArray['message']="Cart items";
                    $jsonArray['delivery_charge']=$deliveryCharges->charges;
                    $jsonArray['data']=$common;
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="No items in your cart!";
            }
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Get Dish Customisations
|--------------------------------------------------------------------------
*/
public function api_getDishCustomisation(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
		    'is_customizable' => 'required',
			'dish_id' => 'required',
			'cart_id' => 'required',
		],
		[
		    'is_customizable.required' => 'Please select if you want to customize',
			'dish_id.required' => 'Please select a dish',
			'cart_id.required' => 'Please select a cart item',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
            $dish=Product::where('id',$request['dish_id'])->first();
            $added_by = $dish->added_by;
            $customisations = Customization::where('provider_id', $added_by)->get();
            
            $cartIdDetails = Cart::where('id', $request['cart_id'])->first();
            
            if(count($customisations) > 0)
            {
                $common = array();
                $r=-1;
                foreach($customisations as $customisation)
                {
                    $r++;
                    $dishCustom = DishCustomisation::where('product_id', $request['dish_id'])->where('cutomisation', $customisation->id)->get();
                    if(count($dishCustom) > 0)
                    {
                        $common[$r]['id'] = $customisation->id;
                        $common[$r]['provider_id'] = $customisation->provider_id;
                        $common[$r]['name'] = $customisation->name;
                        $common[$r]['status'] = $customisation->status;
                        $common[$r]['created_at'] = $customisation->created_at;
                        $common[$r]['updated_at'] = $customisation->updated_at;
                        $common[$r]['all_sub_types'] = $dishCustom;
                        
                        $jsonArray['error']=false;
                        $jsonArray['message']="Customisation";
                        $jsonArray['customisation']=$common;
                    }
                }
                
		    }   
		    else
		    {
		        $jsonArray['error']=true;
                $jsonArray['message']="No customisation availaible for this dish";
		    }
                
                
             
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Add New Address
|--------------------------------------------------------------------------
*/

public function api_addAddress(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required',
        'user_id'	   => 'required', 
        'name'	       => 'required',
        'location'     => 'required',          
        'country'     => 'required',
        'state'     => 'required',
        'city'     => 'required',
        'zip'     => 'required',
        'phone'     => 'required',
        'lattitude'	   => 'required',  
        'longitude'	   => 'required', 
        'address_type'	   => 'required', 
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
			$user=User::where('id',$request['user_id'])->where('roles_id',2)->first();
			$existingUserAddress=UserAddress::where('user_id',$request['user_id'])->first();
			if(!empty($user))
			{
				$user_address=new UserAddress;
                $user_address->user_id=$request['user_id'];
					if($request['address_type']==1)
					{
						$user_address->address=$request['location'];
						$user_address->lattitude=$request['lattitude'];
                        $user_address->longitude=$request['longitude'];
                        $user_address->type=1;
					}
					if($request['address_type']==2)
					{
						$user_address->address=$request['location'];
						$user_address->lattitude=$request['lattitude'];
						$user_address->longitude=$request['longitude'];
						$user_address->type=2;
					}
				if(count($existingUserAddress) > 0)
				{
				    $user_address->primary_status='0';
				}
				else
				{
				    $user_address->primary_status='1';
				    User::where('id', $request['user_id'])->update(['lattitude' => $request['lattitude'], 'longitude' => $request['longitude'], 'cur_lat' => $request['lattitude'], 'cur_lng' => $request['longitude'], 'address' => $request['location'], 'country' => $request['country'], 'city' => $request['city'], 'state' => $request['state'], 'zip' => $request['zip']]);
				}
				$user_address->phone = $request['phone'];
				$user_address->country = $request['country'];
				$user_address->zip = $request['zip'];
				$user_address->city = $request['city'];
				$user_address->state = $request['state'];
                $user_address->name = $request['name'];
                $user_address->save();
                
                //User::where('id', $request['user_id'])->update(['lattitude' => $request['lattitude'], 'longitude' => $request['longitude']]);
                
                $jsonArray['error']=false;
				$jsonArray['message']="A new address has been added "; 
				 	
			}
			else
			{
				$jsonArray['error']=true;
				$jsonArray['message']="Invalid User Id"; 
			}	
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Get All User Address
|--------------------------------------------------------------------------
*/
public function api_getUserAddress(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'user_id' => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles ID',
		    'user_id.required' => 'Please select a user ID!',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
            $userAddress=UserAddress::where('user_id',$request['user_id'])->get();
        
            if(count($userAddress) > 0)
            {
                $jsonArray['error']=false;
                $jsonArray['message']="Addresses";
                $jsonArray['address']=$userAddress;
                
            }
            else 
            {
                $jsonArray['error']=true;
                $jsonArray['message']="No address found!";
            }
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Edit User Address
|--------------------------------------------------------------------------
*/
public function api_editUserAddress(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'user_id' => 'required',
			'address_id' => 'required',
			'name'	       => 'required',
            'location'     => 'required',
            'country'     => 'required',
            'state'     => 'required',
            'city'     => 'required',
            'zip'     => 'required',
            'phone'     => 'required',
            'lattitude'	   => 'required',  
            'longitude'	   => 'required', 
            'address_type'	   => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles id',
			'user_id.required' => 'Please enter user ID!',
		    'address_id.required' => 'Please select a address!',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
            $userAddress=UserAddress::where('id',$request['address_id'])->first();
        
            if(!empty($userAddress))
            {
                if($request['address_type']==1)
				{
					$userAddress->address=$request['location'];
					$userAddress->lattitude=$request['lattitude'];
                    $userAddress->longitude=$request['longitude'];
                    $userAddress->type=1;
				}
				if($request['address_type']==2)
				{
					$userAddress->address=$request['location'];
					$userAddress->lattitude=$request['lattitude'];
					$userAddress->longitude=$request['longitude'];
					$userAddress->type=2;
				}
                $userAddress->phone = $request['phone'];
                $userAddress->country = $request['country'];
				$userAddress->zip = $request['zip'];
				$userAddress->city = $request['city'];
				$userAddress->state = $request['state'];
                $userAddress->name = $request['name'];
                $userAddress->save();
                $userAddress->save();
                
                if($userAddress->primary_status == 1)
                {
                    User::where('id', $request['user_id'])->update(['lattitude' => $request['lattitude'], 'longitude' => $request['longitude'], 'cur_lat' => $request['lattitude'], 'cur_lng' => $request['longitude'], 'address' => $request['location'], 'country' => $request['country'], 'city' => $request['city'], 'state' => $request['state'], 'zip' => $request['zip']]);
                }
                //
                
                $jsonArray['error']=false;
                $jsonArray['message']="Address has been updated";
                $jsonArray['address']=$userAddress;
                
            }
            else 
            {
                $jsonArray['error']=true;
                $jsonArray['message']="No address found!";
            }
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Set Default Address
|--------------------------------------------------------------------------
*/
public function api_setDefaultAddress(Request $request)
{
    try
    {
    	$v = Validator::make($request->all(), [
    		'roles_id' => 'required',
    		'user_id' => 'required',
    		'address_id' => 'required',
    	],
    	[
    		'roles_id.required' => 'Please enter roles id',
    	    'user_id.required' => 'Please enter user ID',
    	    'address_id.required' => 'Please select an address',
    	]);
    	if ($v->fails())
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$v->messages()->first();           
    	}
    	else 
    	{
    	    UserAddress::where('user_id', $request['user_id'])->update(['primary_status' => '0']);
            $userAddress = UserAddress::where('user_id', $request['user_id'])->where('id', $request['address_id'])->first();
            $userAddress->primary_status = '1';
            $userAddress->save();
            
            $userAddressd = UserAddress::where('user_id', $request['user_id'])->where('id', $request['address_id'])->first();
            
            
            
            User::where('id', $request['user_id'])->update(['lattitude' => $userAddressd->lattitude, 'longitude' => $userAddressd->longitude, 'cur_lat' => $userAddressd->lattitude, 'cur_lng' => $userAddressd->longitude, 'address' => $userAddressd->address, 'country' => $userAddressd->country, 'city' => $userAddressd->city, 'state' => $userAddressd->state, 'zip' => $userAddressd->zip]);
            
            $jsonArray['error']=false;
            $jsonArray['message']="This address will be used as your default address.";
        }
    }
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);

} 

/*
|--------------------------------------------------------------------------
| API Delete Address
|--------------------------------------------------------------------------
*/
public function api_deleteAddress(Request $request)
{
    try
    {
    	$v = Validator::make($request->all(), [
    		'roles_id' => 'required',
    		'user_id' => 'required',
    		'address_id' => 'required',
    	],
    	[
    		'roles_id.required' => 'Please enter roles id',
    	    'user_id.required' => 'Please enter user ID',
    	    'address_id.required' => 'Please select an address',
    	]);
    	if ($v->fails())
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$v->messages()->first();           
    	}
    	else 
    	{
    	    $prStatus = UserAddress::where('user_id', $request['user_id'])->where('id', $request['address_id'])->first();
            if($prStatus->primary_status == 1)
            {
                $jsonArray['error']=true;
                $jsonArray['message']="This address is currently set as your default address! Please make another one as default and try again!";
            }
            else
            {
                $status = UserAddress::where('user_id', $request['user_id'])->where('id', $request['address_id'])->delete();
                if($status == 1)
                {
                    $jsonArray['error']=false;
                    $jsonArray['message']="The address has been deleted.";
                }
                else
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="We could not find this address.";
                }
            }
            
        }
    }
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);

}

/*
|--------------------------------------------------------------------------
| API Get Countries List
|--------------------------------------------------------------------------
*/
public function api_countryList(Request $request)
{
    try
    {
    	$v = Validator::make($request->all(), [
    		'roles_id' => 'required',
    	],
    	[
    		'roles_id.required' => 'Please enter roles id',
    	]);
    	if ($v->fails())
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$v->messages()->first();           
    	}
    	else 
    	{
    	    $countries = Country::get();
            
            if(count($countries) > 0)
            {
                $jsonArray['error']=false;
                $jsonArray['data']=$countries;
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="We could not find the country list.";
            }
            
        }
    }
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);

}


/*
|--------------------------------------------------------------------------
| API Make Payment
|--------------------------------------------------------------------------
*/
public function api_makePayment(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'user_id' => 'required',
			'provider_id' => 'required',
			'order_amt' => 'required',
			'delivery_charge' => 'required',
			'payment_type' => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles id',
		    'user_id.required' => 'User Id is missing',
		    'provider_id.required' => 'Please specify provider Id',
		    'order_amt.required' => 'Please enter order amount',
		    'delivery_charge.required' => 'Please enter delivery charge',
		    'payment_type.required' => 'Please select payment method',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
		    $cartID = array();
		    $order_number = time();
            $user=User::where('id',$request['user_id'])->first();
            $providerId=User::where('id',$request['provider_id'])->first();
            $cartItems = Cart::where('user_id', $request->user_id)->get();
            
            if(count($cartItems) > 0)
            {
                if(isset($user) && isset($providerId))
                {
                    $order = new Order;
                    $order->user_id=$request['user_id'];
                    $order->payment_type=$request['payment_type']; //1=cod,2=online
                    $order->order_number=$order_number;
                    $order->provider_id=$request['provider_id'];
                    $order->order_amount=$request['order_amt'];
                    $order->delivery_charge=$request['delivery_charge'];
                    $order->final_order_amount=($request['order_amt'] + $request['delivery_charge']);
                    $order->billing_name=$user->name;
                    $order->billing_number=$user->mobile;
                    $order->billing_email=$user->email;
                    $order->billing_address=$user->address;
                    $order->provider_lat=$providerId->lattitude;
                    $order->provider_lng=$providerId->longitude;
                    $order->order_lat=$user->lattitude;
                    $order->order_lng	=$user->longitude;
                    $order->client_note	=$request['client_note'];
                    
                    $order->billing_city=$user->city;
                    $order->billing_state=$user->state;
                    $order->billing_country=$user->country;
                    
                    $order->billing_zipcode=$user->zip;
                    $order->status=1;
                    
                    if($order->save())
                    {
                        foreach($cartItems as $cartItem)
                        {
                            $orderDetail = new OrderDetail;
                            $orderDetail->order_id = $order->id;
                            $orderDetail->order_number = $order->order_number;
                            $orderDetail->dish_id = $cartItem->dish_id;
                            $orderDetail->price = $cartItem->product_price;
                            $orderDetail->quantity = $cartItem->quantity;
                            $orderDetail->order_price = $cartItem->amount;
                            $orderDetail->product_name = $cartItem->product_name;
                            $orderDetail->product_img = $cartItem->product_img;
                            
                            if($cartItem->is_customizable == 1)
                            {
                                
                                
                                $orderDetail->is_customizable = 1;
                            }
                            else
                            {
                                $orderDetail->is_customizable = 0;
                            }
                            
                            $orderDetail->save();
                            
                            $cartCustomisations = CartCustomisation::where('cart_id', $cartItem->id)->get();
                                foreach($cartCustomisations as $cartCustomisation)
                                {
                                    $orderCustom = new OrderCustomisation;
                                    $orderCustom->order_id = $order->id;
                                    $orderCustom->order_detail_id = $orderDetail->id;
                                    $orderCustom->user_id = $request->user_id;
                                    $orderCustom->dish_id = $cartItem->dish_id;
                                    $orderCustom->customisation_id = $cartCustomisation->customisation_id;
                                    $orderCustom->subtypes_id = $cartCustomisation->subtypes_id;
                                    $orderCustom->customisation = $cartCustomisation->customisation;
                                    $orderCustom->subtypes = $cartCustomisation->subtypes;
                                    $orderCustom->prices = $cartCustomisation->prices;
                                    $orderCustom->save();
                                }
                            
                        }
                        
                        foreach($cartItems as $cartIt)
                        {
                            array_push($cartID, $cartIt->id);
                        }
                        
                        CartCustomisation::whereIn('id', $cartID)->delete();
                        Cart::where('user_id', $request->user_id)->delete();
                        $title = 'Your order has been placed successfully';
                        if(!empty($user->device_token))
                        $this->api_orderPlaceNotification($user->device_token, $title);
                        
                        $jsonArray['error']=false;
                        $jsonArray['message']="Your order has been placed successfuly!";
                    }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['message']="Internal server error. Please try again!";
                    }
                    
                    
                }
                else 
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Invalid User Id or Provider ID";
                }
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="Your cart is currently empty!";
            }
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Order History
|--------------------------------------------------------------------------
*/
public function api_orderHistory(Request $request)
{
    try
    {
    	$v = Validator::make($request->all(), [
    		'roles_id' => 'required',
    		'user_id' => 'required',
    		'order_type' => 'required',
    	],
    	[
    		'roles_id.required' => 'Please enter roles id',
    		'user_id.required' => 'Please enter user id',
    		'order_type.required' => 'Please enter order type',
    	]);
    	if ($v->fails())
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$v->messages()->first();           
    	}
    	else 
    	{
    	    if($request->order_type == 1)
    	    {
    	        $myOrders = Order::with('provider:id,name,email,mobile,lattitude,longitude,user_image,address,state,city,country,zip','order_detail','order_detail.order_customisations')->where('order_status','<',4)->where('user_id', $request->user_id)->orderBy('id', 'DESC')->get();
    	        
    	        if(count($myOrders) > 0)
    			{
    			    $common1 = array();
    			    $r1 = -1;
    			    
    			    foreach($myOrders as $users)
    			    {
    			        $r1++;
    			        $driverRate = RateDriver::where('user_id', $request['user_id'])->where('driver_id', $users->assign_driver_id)->first();
    			        $providerRate = RateProvider::where('user_id', $request['user_id'])->where('provider_id', $users->provider_id)->first();
    			        if(!empty($driverRate))
    			        {
    			            $common1[$r1]['is_driver_rated'] = 1;   
    			            $common1[$r1]['driver_rated'] = $driverRate->rating;
    			        }
    			        else
    			        {
    			            $common1[$r1]['is_driver_rated'] = 0;
    			        }
    			        
    			        if(!empty($providerRate))
    			        {
    			            $common1[$r1]['is_provider_rated'] = 1; 
    			            $common1[$r1]['provider_rated'] = $providerRate->rating;
    			        }
    			        else
    			        {
    			            $common1[$r1]['is_provider_rated'] = 0;
    			        }
    			        
    			        $common1[$r1]['id'] = $users->id;
    			        $common1[$r1]['order_number'] = $users->order_number;
    			        $common1[$r1]['user_id'] = $users->user_id;
    			        $common1[$r1]['provider_id'] = $users->provider_id;
    			        $common1[$r1]['payment_type'] = $users->payment_type;
    			        $common1[$r1]['order_amount'] = $users->order_amount;
    			        $common1[$r1]['delivery_charge'] = $users->delivery_charge;
    			        $common1[$r1]['cancellation_charge'] = $users->cancellation_charge;
    			        $common1[$r1]['final_order_amount'] = $users->final_order_amount;
    			        $common1[$r1]['billing_name'] = $users->billing_name;
    			        $common1[$r1]['billing_number'] = $users->billing_number;
    			        $common1[$r1]['billing_email'] = $users->billing_email;
    			        $common1[$r1]['billing_address'] = $users->billing_address;
    			        $common1[$r1]['provider_lat'] = $users->provider_lat;
    			        $common1[$r1]['provider_lng'] = $users->provider_lng;
    			        $common1[$r1]['order_lat'] = $users->order_lat;
    			        $common1[$r1]['order_lng'] = $users->order_lng;
    			        $common1[$r1]['billing_city'] = $users->billing_city;
    			        $common1[$r1]['billing_state'] = $users->billing_state;
    			        $common1[$r1]['billing_country'] = $users->billing_country;
    			        $common1[$r1]['billing_zipcode'] = $users->billing_zipcode;
    			        
    			        if(!empty($users->delivery_date_time)) 
    			        $deliveryDT = Carbon::parse($users->delivery_date_time)->format('Y-m-d');
    			        else
    			        $deliveryDT = null;
    			        
    			        if(!empty($users->accepted_date)) 
    			        $acceptedDT = Carbon::parse($users->accepted_date)->format('Y-m-d');
    			        else
    			        $acceptedDT = null;
    			        
    			        if(!empty($users->out_for_delivery_date)) 
    			        $outDT = Carbon::parse($users->out_for_delivery_date)->format('Y-m-d');
    			        else
    			        $outDT = null;
    			        
    			        if(!empty($users->delivered_at)) 
    			        $deliveredDT = Carbon::parse($users->delivered_at)->format('Y-m-d');
    			        else
    			        $deliveredDT = null;
    			        
    			        if(!empty($users->canceled_at)) 
    			        $canceledDT = Carbon::parse($users->canceled_at)->format('Y-m-d');
    			        else
    			        $canceledDT = null;
    			        
    			        if(!empty($users->refunded_at)) 
    			        $refDT = Carbon::parse($users->refunded_at)->format('Y-m-d');
    			        else
    			        $refDT = null;
    			        
    			        $common1[$r1]['delivery_date_time'] = $deliveryDT;
    			        $common1[$r1]['status'] = $users->status;
    			        $common1[$r1]['assign_driver_id'] = $users->assign_driver_id;
    			        $common1[$r1]['is_driver_accept'] = $users->is_driver_accept;
    			        $common1[$r1]['order_status'] = $users->order_status;
    			        $common1[$r1]['accepted_date'] = $acceptedDT;
    			        
    			        $common1[$r1]['out_for_delivery_date'] = $outDT;
    			        $common1[$r1]['delivered_at'] = $deliveredDT;
    			        $common1[$r1]['canceled_at'] = $canceledDT;
    			        $common1[$r1]['refunded_at'] = $refDT;
    			        $common1[$r1]['client_note'] = $users->client_note;
    			        $common1[$r1]['created_at'] = $users->created_at ? $users->created_at->format('Y-m-d H:i:s') : null;
    			        $common1[$r1]['updated_at'] = $users->updated_at ? $users->updated_at->format('Y-m-d H:i:s') : null;
    			        
    			        
    			        $common1[$r1]['provider']['id'] = $users->provider->id ?? null;
    			        $common1[$r1]['provider']['name'] = $users->provider->name ?? null;
    			        $common1[$r1]['provider']['email'] = $users->provider->email ?? null;
    			        $common1[$r1]['provider']['mobile'] = $users->provider->mobile ?? null;
    			        $common1[$r1]['provider']['user_image'] = $users->provider->user_image ?? null;
    			        $common1[$r1]['provider']['lattitude'] = $users->provider->lattitude ?? null;
    			        $common1[$r1]['provider']['longitude'] = $users->provider->longitude ?? null;
    			        //$common1[$r1]['provider']['cur_lat'] = $users->provider->cur_lat ?? null;
    			        //$common1[$r1]['provider']['cur_lng'] = $users->provider->cur_lng ?? null;
    			        $common1[$r1]['provider']['address'] = $users->provider->address ?? null;
    			        $common1[$r1]['provider']['country'] = $users->provider->country ?? null;
    			        $common1[$r1]['provider']['state'] = $users->provider->state ?? null;
    			        $common1[$r1]['provider']['city'] = $users->provider->city ?? null;
    			        $common1[$r1]['provider']['zip'] = $users->provider->zip ?? null;
    			        
    			        $orderDetail = OrderDetail::with('order_customisations')->where('order_id', $users->id)->get();
    			        
    			        $common1[$r1]['order_detail'] = $orderDetail;
    			    }
    			}
    	        
    	    }
	        elseif($request->order_type == 2)
	        {
	            $myOrders = Order::with('provider:id,name,user_image,address,state,city,country,zip','order_detail','order_detail.order_customisations')->where('order_status','>=',4)->where('user_id', $request->user_id)->orderBy('id', 'DESC')->get();
	            
	            if(count($myOrders) > 0)
    			{
    			    $common1 = array();
    			    $r1 = -1;
    			    
    			    foreach($myOrders as $users)
    			    {
    			        $r1++;
    			        $driverRate = RateDriver::where('user_id', $request['user_id'])->where('driver_id', $users->assign_driver_id)->first();
    			        $providerRate = RateProvider::where('user_id', $request['user_id'])->where('provider_id', $users->provider_id)->first();
    			        if(!empty($driverRate))
    			        {
    			            $common1[$r1]['is_driver_rated'] = 1;   
    			            $common1[$r1]['driver_rated'] = $driverRate->rating;
    			        }
    			        else
    			        {
    			            $common1[$r1]['is_driver_rated'] = 0;
    			        }
    			        
    			        if(!empty($providerRate))
    			        {
    			            $common1[$r1]['is_provider_rated'] = 1; 
    			            $common1[$r1]['provider_rated'] = $providerRate->rating;
    			        }
    			        else
    			        {
    			            $common1[$r1]['is_provider_rated'] = 0;
    			        }
    			        
    			        $common1[$r1]['id'] = $users->id;
    			        $common1[$r1]['order_number'] = $users->order_number;
    			        $common1[$r1]['user_id'] = $users->user_id;
    			        $common1[$r1]['provider_id'] = $users->provider_id;
    			        $common1[$r1]['payment_type'] = $users->payment_type;
    			        $common1[$r1]['order_amount'] = $users->order_amount;
    			        $common1[$r1]['delivery_charge'] = $users->delivery_charge;
    			        $common1[$r1]['cancellation_charge'] = $users->cancellation_charge;
    			        $common1[$r1]['final_order_amount'] = $users->final_order_amount;
    			        $common1[$r1]['billing_name'] = $users->billing_name;
    			        $common1[$r1]['billing_number'] = $users->billing_number;
    			        $common1[$r1]['billing_email'] = $users->billing_email;
    			        $common1[$r1]['billing_address'] = $users->billing_address;
    			        $common1[$r1]['provider_lat'] = $users->provider_lat;
    			        $common1[$r1]['provider_lng'] = $users->provider_lng;
    			        $common1[$r1]['order_lat'] = $users->order_lat;
    			        $common1[$r1]['order_lng'] = $users->order_lng;
    			        $common1[$r1]['billing_city'] = $users->billing_city;
    			        $common1[$r1]['billing_state'] = $users->billing_state;
    			        $common1[$r1]['billing_country'] = $users->billing_country;
    			        $common1[$r1]['billing_zipcode'] = $users->billing_zipcode;
    			        
    			        if(!empty($users->delivery_date_time)) 
    			        $deliveryDT = Carbon::parse($users->delivery_date_time)->format('Y-m-d');
    			        else
    			        $deliveryDT = null;
    			        
    			        if(!empty($users->accepted_date)) 
    			        $acceptedDT = Carbon::parse($users->accepted_date)->format('Y-m-d');
    			        else
    			        $acceptedDT = null;
    			        
    			        if(!empty($users->out_for_delivery_date)) 
    			        $outDT = Carbon::parse($users->out_for_delivery_date)->format('Y-m-d');
    			        else
    			        $outDT = null;
    			        
    			        if(!empty($users->delivered_at)) 
    			        $deliveredDT = Carbon::parse($users->delivered_at)->format('Y-m-d');
    			        else
    			        $deliveredDT = null;
    			        
    			        if(!empty($users->canceled_at)) 
    			        $canceledDT = Carbon::parse($users->canceled_at)->format('Y-m-d');
    			        else
    			        $canceledDT = null;
    			        
    			        if(!empty($users->refunded_at)) 
    			        $refDT = Carbon::parse($users->refunded_at)->format('Y-m-d');
    			        else
    			        $refDT = null;
    			        
    			        $common1[$r1]['delivery_date_time'] = $deliveryDT;
    			        $common1[$r1]['status'] = $users->status;
    			        $common1[$r1]['assign_driver_id'] = $users->assign_driver_id;
    			        $common1[$r1]['is_driver_accept'] = $users->is_driver_accept;
    			        $common1[$r1]['order_status'] = $users->order_status;
    			        $common1[$r1]['accepted_date'] = $acceptedDT;
    			        
    			        $common1[$r1]['out_for_delivery_date'] = $outDT;
    			        $common1[$r1]['delivered_at'] = $deliveredDT;
    			        $common1[$r1]['canceled_at'] = $canceledDT;
    			        $common1[$r1]['refunded_at'] = $refDT;
    			        $common1[$r1]['client_note'] = $users->client_note;
    			        $common1[$r1]['created_at'] = $users->created_at ? $users->created_at->format('Y-m-d H:i:s') : null;
    			        $common1[$r1]['updated_at'] = $users->updated_at ? $users->updated_at->format('Y-m-d H:i:s') : null;
    			        
    			        
    			        $common1[$r1]['provider']['id'] = $users->provider->id ?? null;
    			        $common1[$r1]['provider']['name'] = $users->provider->name ?? null;
    			        $common1[$r1]['provider']['email'] = $users->provider->email ?? null;
    			        $common1[$r1]['provider']['mobile'] = $users->provider->mobile ?? null;
    			        $common1[$r1]['provider']['user_image'] = $users->provider->user_image ?? null;
    			        $common1[$r1]['provider']['lattitude'] = $users->provider->lattitude ?? null;
    			        $common1[$r1]['provider']['longitude'] = $users->provider->longitude ?? null;
    			        //$common1[$r1]['provider']['cur_lat'] = $users->provider->cur_lat ?? null;
    			        //$common1[$r1]['provider']['cur_lng'] = $users->provider->cur_lng ?? null;
    			        $common1[$r1]['provider']['address'] = $users->provider->address ?? null;
    			        $common1[$r1]['provider']['country'] = $users->provider->country ?? null;
    			        $common1[$r1]['provider']['state'] = $users->provider->state ?? null;
    			        $common1[$r1]['provider']['city'] = $users->provider->city ?? null;
    			        $common1[$r1]['provider']['zip'] = $users->provider->zip ?? null;
    			        
    			        $orderDetail = OrderDetail::with('order_customisations')->where('order_id', $users->id)->get();
    			        
    			        $common1[$r1]['order_detail'] = $orderDetail;
    			    }
    			}
	            
	        }
    	        
            
            if(count($myOrders) > 0)
            {
                $jsonArray['error']=false;
                $jsonArray['orders']=$common1;
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="No orders found!";
            }
            
        }
    }
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);

}
    
/*
|--------------------------------------------------------------------------
| API Contact Admin
|--------------------------------------------------------------------------
*/
public function api_contactAdmin(Request $request)
{
    try
    {
    	$v = Validator::make($request->all(), [
    		'roles_id' => 'required',
    		'user_id' => 'required',
    		'subject' => 'required',
    		'message' => 'required',
    	],
    	[
    		'roles_id.required' => 'Please enter roles id',
    		'user_id.required' => 'Please enter user id',
    	    'subject.required' => 'Please enter title',
    	    'message.required' => 'Please enter your message',
    	]);
    	if ($v->fails())
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$v->messages()->first();           
    	}
    	else 
    	{
            $fav = new Contact;
            $fav->subject=$request['subject'];
            $fav->message=$request['message'];
            $fav->save();
            
            $user = User::where('id', $request['user_id'])->first();
            
            /*Mail::to('shubham.kumar@webmobril.com')->send(new ContactMail($user->name,$request['roles_id'],$request['subject'],$request['message']),function($message){
                    });*/
            
            $jsonArray['error']=false;
            $jsonArray['message']="Thankyou! Your message has been sent.";
        }
    }
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
return response()->json($jsonArray);

}



/*
|--------------------------------------------------------------------------
| API Update Profile Driver
|--------------------------------------------------------------------------
*/

public function api_update_profileDriver(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'user_id' => 'required',
				'roles_id' => 'required',
				'name' => 'required',
				'address' => 'required',
				'city' => 'required',
				'state' => 'required',
				'email' => 'unique:users,email,'.$request['user_id'],
			],
			[
				'user_id.required' => 'Please enter user id',
				'roles_id.required' => 'Please enter roles id',
				'name.required' => 'Please enter name',
				'address.required' => 'Please enter address',
				'city.required' => 'Please enter city',
				'state.required' => 'Please enter state',
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
			$users = User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->first();
			
			$target='siteimages/driver/';
            
			if(!empty($users))
			{
			    $users->name = $request['name'];
				$users->email = $request['email'];
				$users->address = $request['address'];
				$users->country = $request['country'];
				$users->state = $request['state'];
				$users->city = $request['city'];
				$users->vehicle_number = $request['vehicle_number'];
				
                            
            			    
                $header_logo=$request->file('profile_image');
                if(!empty($header_logo))
                {
                    $headerImageName=$header_logo->getClientOriginalName();
                    $ext1=$header_logo->getClientOriginalExtension();
                    $temp1=explode(".",$headerImageName);
                    $newHeaderLogo='driver'.rand()."".round(microtime(true)).".".end($temp1);
                    $headerTarget='siteimages/driver/'.$newHeaderLogo;
                    $header_logo->move($target,$newHeaderLogo);
                    
                }
                else
                {
                    $headerTarget="";
                }
                $users->user_image = $headerTarget;
               
				$users->save();
				
				
				$userDtl = User::where('id', $request['user_id'])->first();
				
				$jsonArray['error'] = false;
				$jsonArray['message'] = "Your profile has been updated!";
				$jsonArray['data'] = $userDtl;
				
				
			}
			else
			{
				$jsonArray['error'] = true;
				$jsonArray['message'] = "There is some error while updating profile"; 
			}
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}
   
   
/*
|--------------------------------------------------------------------------
| API Upload Driver Documents
|--------------------------------------------------------------------------
*/

public function api_uploadDocuments(Request $request)
{
	try
	{
		$v = Validator::make($request->all(), [
				'user_id' => 'required',
				'roles_id' => 'required',
			],
			[
				'user_id.required' => 'Please enter user id',
				'roles_id.required' => 'Please enter roles id',
			]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
			$users = User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->first();
			$driverDocuments = UserDocument::where('user_id',$request['user_id'])->first();
			
			$target='siteimages/driver/';
            $target_doc='siteimages/driver_documents/';
			if(!empty($users))
			{
			    if(!empty($driverDocuments))
			    {
			        $userDocument = $driverDocuments;
			        $userDocument->user_id = $request['user_id'];
			    }
			    else
			    {
			        $userDocument = new UserDocument;
			        $userDocument->user_id = $request['user_id'];
			    }
			        
			        //switch ($request['key']) 
			        //{
                        
                        if(!empty($request['1']))
                        {    
                            //dl front
                            $dl_front=$request->file('1');
                            if(!empty($dl_front))
                            {
                                $dlf=$dl_front->getClientOriginalName();
                                $dlext=$dl_front->getClientOriginalExtension();
                                $explodedl=explode(".",$dlf);
                                $newdl='dl'.rand()."".round(microtime(true)).".".end($explodedl);
                                $headerdl='siteimages/driver_documents/'.$newdl;
                                $dl_front->move($target_doc,$newdl);
                                
                            }
                            else
                            {
                                $headerdl="";
                            }
                            $userDocument->driving_license_front = $headerdl;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['2']))
                        {
                            //dl back
                            $dl_back=$request->file('2');
                            if(!empty($dl_back))
                            {
                                $dlb=$dl_back->getClientOriginalName();
                                $dlbext=$dl_back->getClientOriginalExtension();
                                $explodedlb=explode(".",$dlb);
                                $newdlb='dl'.rand()."".round(microtime(true)).".".end($explodedlb);
                                $headerdlb='siteimages/driver_documents/'.$newdlb;
                                $dl_back->move($target_doc,$newdlb);
                                
                            }
                            else
                            {
                                $headerdlb="";
                            }
                            $userDocument->driving_license_back = $headerdlb;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['3']))
                        {
                            //id front
                            $id_front=$request->file('3');
                            if(!empty($id_front))
                            {
                                $idf=$id_front->getClientOriginalName();
                                $idfext=$id_front->getClientOriginalExtension();
                                $explodeidf=explode(".",$idf);
                                $newidf='id'.rand()."".round(microtime(true)).".".end($explodeidf);
                                $headeridf='siteimages/driver_documents/'.$newidf;
                                $id_front->move($target_doc,$newidf);
                                
                            }
                            else
                            {
                                $headeridf="";
                            }
                            $userDocument->id_card_front = $headeridf;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['4']))
                        {
                            //id back
                            $id_back=$request->file('4');
                            if(!empty($id_back))
                            {
                                $idb=$id_back->getClientOriginalName();
                                $idfext=$id_back->getClientOriginalExtension();
                                $explodeidb=explode(".",$idb);
                                $newidb='id'.rand()."".round(microtime(true)).".".end($explodeidb);
                                $headeridb='siteimages/driver_documents/'.$newidb;
                                $id_back->move($target_doc,$newidb);
                                
                            }
                            else
                            {
                                $headeridb="";
                            }
                            $userDocument->id_card_back = $headeridb;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['5']))
                        {
                            //car registration front
                            $car_regf=$request->file('5');
                            if(!empty($car_regf))
                            {
                                $cargf=$car_regf->getClientOriginalName();
                                $cargfext=$car_regf->getClientOriginalExtension();
                                $explodecarrf=explode(".",$cargf);
                                $newcarrf='reg'.rand()."".round(microtime(true)).".".end($explodecarrf);
                                $headercarrf='siteimages/driver_documents/'.$newcarrf;
                                $car_regf->move($target_doc,$newcarrf);
                                
                            }
                            else
                            {
                                $headercarrf="";
                            }
                            $userDocument->car_registration_front = $headercarrf;
                            $userDocument->save();
                            
                        }
                        if(!empty($request['6']))
                        {
                            //car registration back
                            $car_regb=$request->file('6');
                            if(!empty($car_regb))
                            {
                                $cargb=$car_regb->getClientOriginalName();
                                $cargbext=$car_regb->getClientOriginalExtension();
                                $explodecarrb=explode(".",$cargb);
                                $newcarrb='reg'.rand()."".round(microtime(true)).".".end($explodecarrb);
                                $headercarrb='siteimages/driver_documents/'.$newcarrb;
                                $car_regb->move($target_doc,$newcarrb);
                                
                            }
                            else
                            {
                                $headercarrb="";
                            }
                            $userDocument->car_registration_back = $headercarrb;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['7']))
                        {
                            //car image 1
                            $car_img1=$request->file('7');
                            if(!empty($car_img1))
                            {
                                $carimg1=$car_img1->getClientOriginalName();
                                $carimgext1=$car_img1->getClientOriginalExtension();
                                $explodecarimg1=explode(".",$carimg1);
                                $newcarimg1='img'.rand()."".round(microtime(true)).".".end($explodecarimg1);
                                $headercarimg1='siteimages/driver_documents/'.$newcarimg1;
                                $car_img1->move($target_doc,$newcarimg1);
                                
                            }
                            else
                            {
                                $headercarimg1="";
                            }
                            $userDocument->car_images_1 = $headercarimg1;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['8']))
                        {
                            //car image 2
                            $car_img2=$request->file('8');
                            if(!empty($car_img2))
                            {
                                $carimg2=$car_img2->getClientOriginalName();
                                $carimgext2=$car_img2->getClientOriginalExtension();
                                $explodecarimg2=explode(".",$carimg2);
                                $newcarimg2='img'.rand()."".round(microtime(true)).".".end($explodecarimg2);
                                $headercarimg2='siteimages/driver_documents/'.$newcarimg2;
                                $car_img2->move($target_doc,$newcarimg2);
                                
                            }
                            else
                            {
                                $headercarimg2="";
                            }
                            $userDocument->car_images_2 = $headercarimg2;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['9']))
                        {
                            //car image 3
                            $car_img3=$request->file('9');
                            if(!empty($car_img3))
                            {
                                $carimg3=$car_img3->getClientOriginalName();
                                $carimgext3=$car_img3->getClientOriginalExtension();
                                $explodecarimg3=explode(".",$carimg3);
                                $newcarimg3='img'.rand()."".round(microtime(true)).".".end($explodecarimg3);
                                $headercarimg3='siteimages/driver_documents/'.$newcarimg3;
                                $car_img3->move($target_doc,$newcarimg3);
                                
                            }
                            else
                            {
                                $headercarimg3="";
                            }
                            $userDocument->car_images_3 = $headercarimg3;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['10']))
                        {
                            //car image 4
                            $car_img4=$request->file('10');
                            if(!empty($car_img4))
                            {
                                $carimg4=$car_img4->getClientOriginalName();
                                $carimgext4=$car_img4->getClientOriginalExtension();
                                $explodecarimg4=explode(".",$carimg4);
                                $newcarimg4='img'.rand()."".round(microtime(true)).".".end($explodecarimg4);
                                $headercarimg4='siteimages/driver_documents/'.$newcarimg4;
                                $car_img4->move($target_doc,$newcarimg4);
                                
                            }
                            else
                            {
                                $headercarimg4="";
                            }
                            $userDocument->car_images_4 = $headercarimg4;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['11']))
                        {
                            //non criminal rec front
                            $noncriminal1=$request->file('11');
                            if(!empty($noncriminal1))
                            {
                                $noncimgf=$noncriminal1->getClientOriginalName();
                                $nonimgextf=$noncriminal1->getClientOriginalExtension();
                                $explodenonf=explode(".",$noncimgf);
                                $newnonimgf='rec'.rand()."".round(microtime(true)).".".end($explodenonf);
                                $headernonf='siteimages/driver_documents/'.$newnonimgf;
                                $noncriminal1->move($target_doc,$newnonimgf);
                                
                            }
                            else
                            {
                                $headernonf="";
                            }
                            $userDocument->non_criminal_rec_front = $headernonf;
                            $userDocument->save();$userDocument->save();
                            //break;
                        }
                        if(!empty($request['12']))
                        {
                            //non criminal rec back
                            $noncriminal2=$request->file('12');
                            if(!empty($noncriminal2))
                            {
                                $noncimgb=$noncriminal2->getClientOriginalName();
                                $nonimgextb=$noncriminal2->getClientOriginalExtension();
                                $explodenonb=explode(".",$noncimgb);
                                $newnonimgb='rec'.rand()."".round(microtime(true)).".".end($explodenonb);
                                $headernonb='siteimages/driver_documents/'.$newnonimgb;
                                $noncriminal2->move($target_doc,$newnonimgb);
                                
                            }
                            else
                            {
                                $headernonb="";
                            }
                            $userDocument->non_criminal_rec_back = $headernonb;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['13']))
                        {
                            //other doc 1
                            $otherdoc1=$request->file('13');
                            if(!empty($otherdoc1))
                            {
                                $otherimg1=$otherdoc1->getClientOriginalName();
                                $otherext1=$otherdoc1->getClientOriginalExtension();
                                $explodeother1=explode(".",$otherimg1);
                                $newotherimg1='doc'.rand()."".round(microtime(true)).".".end($explodeother1);
                                $headerother1='siteimages/driver_documents/'.$newotherimg1;
                                $otherdoc1->move($target_doc,$newotherimg1);
                                
                            }
                            else
                            {
                                $headerother1="";
                            }
                            $userDocument->other_doc_1 = $headerother1;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['14']))
                        {
                            //other doc 2
                            $otherdoc2=$request->file('14');
                            if(!empty($otherdoc2))
                            {
                                $otherimg2=$otherdoc2->getClientOriginalName();
                                $otherext2=$otherdoc2->getClientOriginalExtension();
                                $explodeother2=explode(".",$otherimg2);
                                $newotherimg2='doc'.rand()."".round(microtime(true)).".".end($explodeother2);
                                $headerother2='siteimages/driver_documents/'.$newotherimg2;
                                $otherdoc2->move($target_doc,$newotherimg2);
                                
                            }
                            else
                            {
                                $headerother2="";
                            }
                            $userDocument->other_doc_2 = $headerother2;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['15']))
                        {
                            //other doc 3
                            $otherdoc3=$request->file('15');
                            if(!empty($otherdoc3))
                            {
                                $otherimg3=$otherdoc3->getClientOriginalName();
                                $otherext3=$otherdoc3->getClientOriginalExtension();
                                $explodeother3=explode(".",$otherimg3);
                                $newotherimg3='doc'.rand()."".round(microtime(true)).".".end($explodeother3);
                                $headerother3='siteimages/driver_documents/'.$newotherimg3;
                                $otherdoc3->move($target_doc,$newotherimg3);
                                
                            }
                            else
                            {
                                $headerother3="";
                            }
                            $userDocument->other_doc_3 = $headerother3;
                            $userDocument->save();
                            //break;
                        }
                        if(!empty($request['16']))
                        {
                            //other doc 4
                            $otherdoc4=$request->file('16');
                            if(!empty($otherdoc4))
                            {
                                $otherimg4=$otherdoc4->getClientOriginalName();
                                $otherext4=$otherdoc4->getClientOriginalExtension();
                                $explodeother4=explode(".",$otherimg4);
                                $newotherimg4='doc'.rand()."".round(microtime(true)).".".end($explodeother4);
                                $headerother4='siteimages/driver_documents/'.$newotherimg4;
                                $otherdoc4->move($target_doc,$newotherimg4);
                                
                            }
                            else
                            {
                                $headerother4="";
                            }
                            $userDocument->other_doc_4 = $headerother4;
                            $userDocument->save();
                            //break;
                        }
                        
                
                    
				$userDtl = UserDocument::where('user_id', $request['user_id'])->first();
				
				$jsonArray['error'] = false;
				$jsonArray['message'] = "Document has been uploaded!";
				$jsonArray['data'] = $userDtl;
				
				
			}
			else
			{
				$jsonArray['error'] = true;
				$jsonArray['message'] = "There is some error while uploading document"; 
			}
		}
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Cancel Order
|--------------------------------------------------------------------------
*/

public function api_cancelOrder(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required',
        'user_id'	   => 'required', 
        'order_id'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles ID',
            'user_id.required' => 'Please enter user ID',
            'order_id.required' => 'Please enter order ID',
            ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
			$order=Order::with('user','provider','order_detail','order_detail.order_customisations')->where('id',$request['order_id'])->where('order_status',1)->first();
			
			if(!empty($order))
			{
			    $order->order_status = 5;
			    $order->canceled_at = Carbon::now();
			    $order->save();
			    
			    $user = User::where('id', $order->user_id)->first();
			    
			    if(!empty($user->device_token))
			    {
    			    $title = 'Your order has been cancelled';
    			    $this->sendOrderCancelNotification($title,$user->device_token,$order);
			    }
			    
		        $jsonArray['error']=false;
		        //$jsonArray['data']=$userCard;
		        $jsonArray['message']="Your order has been cancelled.";
			}
			else
			{
				$jsonArray['error']=true;
				$jsonArray['message']="Could not cancel this order!"; 
			}	
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Assign Order To Driver
|--------------------------------------------------------------------------
*/

public function AssignToDriver()
{
    $current_date = Carbon::now();
    
    $orders = Order::with('user','provider')->where('status',1)->where('assign_driver_id',0)->where('order_status','<',2)->get();
   
    /*$orders = DB::table('orders')
    ->join('users', 'orders.user_id', '=', 'users.id')
    ->leftJoin('users', 'orders.provider_id', '=', 'users.id')
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
    ->get();*/
    
    
    
    if(!empty($orders->toArray()))
    {
        foreach($orders as $order)
        {
            if(!empty($order->billing_country))
            {
            $dist=1;
            $mylat=$order->provider->lattitude;
            $mylon=$order->provider->longitude;
            
            $lon1 = $mylon-$dist/abs(cos(deg2rad($mylat))*69);
            $lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
            
            $lat1 = $mylat-($dist/69);
            $lat2 = $mylat+($dist/69);
            
            $android_drivers = DB::select('SELECT u.id as driver_id,u.device_type,u.device_token,
            3956 2 ASIN(SQRT( POWER(SIN((u.cur_lat - ?) pi()/180 / 2), 2) +COS(u.cur_lat pi()/180) COS(? pi()/180)
            POWER(SIN((u.cur_lng -?) pi()/180 / 2), 2) )) as distance FROM users u where u.ready_for_pickup=1 and u.cur_lng between ? and ? and u.cur_lat between ? and ?'
            ,[$mylat,$mylat,$mylon,$lon1,$lon2,$lat1,$lat2]);
            
                if(!empty($android_drivers))
                {
                    foreach($android_drivers as $androiddrivers)
                    {
                        /*$fbn=new FirebaseNotification;
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
                        $fbn->save();*/
                        $this->NotifyDriver($androiddrivers->device_token,$fbn);
                    }
                }
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| API Get Driver Orders
|--------------------------------------------------------------------------
*/

public function api_driverHomePage(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'user_id'	   => 'required', 
        'tab'	   => 'required',
        ],
        [
            'user_id.required' => 'Please enter user ID',
            'tab.required' => 'Please select tab',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            $driverLatLng = User::where('id', $request['user_id'])->first();
            if($request->tab == 1)
            {
                $user = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('assign_driver_id',$request['user_id'])->where('order_status', 1)->get();
			
    			if(count($user) > 0)
    			{
    			    $common1 = array();
    			    $r1 = -1;
    			    
    			    foreach($user as $users)
    			    {
    			        $r1++;
    			        if((!empty($driverLatLng->cur_lat) && !empty($driverLatLng->cur_lng) && !empty($users->provider->lattitude) && !empty($users->provider->longitude)))
    			        {
    			            $distanceCal = $this->distanceCalculation($driverLatLng->cur_lat, $driverLatLng->cur_lng, $users->provider->lattitude, $users->provider->longitude);
    			            $common1[$r1]['distance'] = $distanceCal;   
    			        }
    			        else
    			        {
    			            $common1[$r1]['distance'] = 0.00;
    			        }
    			        
    			        $common1[$r1]['id'] = $users->id;
    			        $common1[$r1]['order_number'] = $users->order_number;
    			        $common1[$r1]['user_id'] = $users->user_id;
    			        $common1[$r1]['provider_id'] = $users->provider_id;
    			        $common1[$r1]['payment_type'] = $users->payment_type;
    			        $common1[$r1]['order_amount'] = $users->order_amount;
    			        $common1[$r1]['delivery_charge'] = $users->delivery_charge;
    			        $common1[$r1]['cancellation_charge'] = $users->cancellation_charge;
    			        $common1[$r1]['final_order_amount'] = $users->final_order_amount;
    			        $common1[$r1]['billing_name'] = $users->billing_name;
    			        $common1[$r1]['billing_number'] = $users->billing_number;
    			        $common1[$r1]['billing_email'] = $users->billing_email;
    			        $common1[$r1]['billing_address'] = $users->billing_address;
    			        $common1[$r1]['provider_lat'] = $users->provider_lat;
    			        $common1[$r1]['provider_lng'] = $users->provider_lng;
    			        $common1[$r1]['order_lat'] = $users->order_lat;
    			        $common1[$r1]['order_lng'] = $users->order_lng;
    			        $common1[$r1]['billing_city'] = $users->billing_city;
    			        $common1[$r1]['billing_state'] = $users->billing_state;
    			        $common1[$r1]['billing_country'] = $users->billing_country;
    			        $common1[$r1]['billing_zipcode'] = $users->billing_zipcode;
    			        
    			        if(!empty($users->delivery_date_time)) 
    			        $deliveryDT = Carbon::parse($users->delivery_date_time)->format('Y-m-d');
    			        else
    			        $deliveryDT = null;
    			        
    			        if(!empty($users->accepted_date)) 
    			        $acceptedDT = Carbon::parse($users->accepted_date)->format('Y-m-d');
    			        else
    			        $acceptedDT = null;
    			        
    			        if(!empty($users->out_for_delivery_date)) 
    			        $outDT = Carbon::parse($users->out_for_delivery_date)->format('Y-m-d');
    			        else
    			        $outDT = null;
    			        
    			        if(!empty($users->delivered_at)) 
    			        $deliveredDT = Carbon::parse($users->delivered_at)->format('Y-m-d');
    			        else
    			        $deliveredDT = null;
    			        
    			        if(!empty($users->canceled_at)) 
    			        $canceledDT = Carbon::parse($users->canceled_at)->format('Y-m-d');
    			        else
    			        $canceledDT = null;
    			        
    			        if(!empty($users->refunded_at)) 
    			        $refDT = Carbon::parse($users->refunded_at)->format('Y-m-d');
    			        else
    			        $refDT = null;
    			        
    			        $common1[$r1]['delivery_date_time'] = $deliveryDT;
    			        $common1[$r1]['status'] = $users->status;
    			        $common1[$r1]['assign_driver_id'] = $users->assign_driver_id;
    			        $common1[$r1]['is_driver_accept'] = $users->is_driver_accept;
    			        $common1[$r1]['order_status'] = $users->order_status;
    			        $common1[$r1]['accepted_date'] = $acceptedDT;
    			        
    			        $common1[$r1]['out_for_delivery_date'] = $outDT;
    			        $common1[$r1]['delivered_at'] = $deliveredDT;
    			        $common1[$r1]['canceled_at'] = $canceledDT;
    			        $common1[$r1]['refunded_at'] = $refDT;
    			        $common1[$r1]['client_note'] = $users->client_note;
    			        $common1[$r1]['created_at'] = $users->created_at ? $users->created_at->format('Y-m-d H:i:s') : null;
    			        $common1[$r1]['updated_at'] = $users->updated_at ? $users->updated_at->format('Y-m-d H:i:s') : null;
    			        
    			        $common1[$r1]['user']['id'] = $users->user->id ?? null;
    			        $common1[$r1]['user']['name'] = $users->user->name ?? null;
    			        $common1[$r1]['user']['email'] = $users->user->email ?? null;
    			        $common1[$r1]['user']['mobile'] = $users->user->mobile ?? null;
    			        $common1[$r1]['user']['user_image'] = $users->user->user_image ?? null;
    			        $common1[$r1]['user']['lattitude'] = $users->user->lattitude ?? null;
    			        $common1[$r1]['user']['longitude'] = $users->user->longitude ?? null;
    			        $common1[$r1]['user']['address'] = $users->user->address ?? null;
    			        $common1[$r1]['user']['country'] = $users->user->country ?? null;
    			        $common1[$r1]['user']['state'] = $users->user->state ?? null;
    			        $common1[$r1]['user']['city'] = $users->user->city ?? null;
    			        $common1[$r1]['user']['zip'] = $users->user->zip ?? null;
    			        
    			        $common1[$r1]['provider']['id'] = $users->provider->id ?? null;
    			        $common1[$r1]['provider']['name'] = $users->provider->name ?? null;
    			        $common1[$r1]['provider']['email'] = $users->provider->email ?? null;
    			        $common1[$r1]['provider']['mobile'] = $users->provider->mobile ?? null;
    			        $common1[$r1]['provider']['user_image'] = $users->provider->user_image ?? null;
    			        $common1[$r1]['provider']['lattitude'] = $users->provider->lattitude ?? null;
    			        $common1[$r1]['provider']['longitude'] = $users->provider->longitude ?? null;
    			        //$common1[$r1]['provider']['cur_lat'] = $users->provider->cur_lat ?? null;
    			        //$common1[$r1]['provider']['cur_lng'] = $users->provider->cur_lng ?? null;
    			        $common1[$r1]['provider']['address'] = $users->provider->address ?? null;
    			        $common1[$r1]['provider']['country'] = $users->provider->country ?? null;
    			        $common1[$r1]['provider']['state'] = $users->provider->state ?? null;
    			        $common1[$r1]['provider']['city'] = $users->provider->city ?? null;
    			        $common1[$r1]['provider']['zip'] = $users->provider->zip ?? null;
    			    }
    			    
    		        $jsonArray['error']=false;
    		        $jsonArray['data']=$common1;
    			}
    			else
    			{
    				$jsonArray['error']=true;
    				$jsonArray['message']="No new order found!"; 
    			}
            }
            elseif($request->tab == 2)
            {
                $user = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('assign_driver_id',$request['user_id'])->where('is_driver_accept', 1)->where('order_status', 2)->get();
			
    			if(count($user) > 0)
    			{
    		        $jsonArray['error']=false;
    		        $jsonArray['data']=$user;
    			}
    			else
    			{
    				$jsonArray['error']=true;
    				$jsonArray['message']="You have not accepted any order!"; 
    			}
            }
            elseif($request->tab == 3)
            {
                $user = Order::with('user','provider')->where('assign_driver_id',$request['user_id'])->where('order_status', 3)->get();
			
    			if(count($user) > 0)
    			{
    			    
    			    $common1 = array();
    			    $r1 = -1;
    			    
    			    foreach($user as $users)
    			    {
    			        $r1++;
    			        if(!empty(($driverLatLng->cur_lat) && !empty($driverLatLng->cur_lng) && !empty($users->user->lattitude) && !empty($users->user->longitude)))
    			        {
    			            $distanceCal = $this->distanceCalculation($driverLatLng->cur_lat, $driverLatLng->cur_lng, $users->user->lattitude, $users->user->longitude);
    			            $common1[$r1]['distance'] = $distanceCal;   
    			        }
    			        else
    			        {
    			            $common1[$r1]['distance'] = 0.00;
    			        }
    			        
    			        $common1[$r1]['id'] = $users->id;
    			        $common1[$r1]['order_number'] = $users->order_number;
    			        $common1[$r1]['user_id'] = $users->user_id;
    			        $common1[$r1]['provider_id'] = $users->provider_id;
    			        $common1[$r1]['payment_type'] = $users->payment_type;
    			        $common1[$r1]['order_amount'] = $users->order_amount;
    			        $common1[$r1]['delivery_charge'] = $users->delivery_charge;
    			        $common1[$r1]['cancellation_charge'] = $users->cancellation_charge;
    			        $common1[$r1]['final_order_amount'] = $users->final_order_amount;
    			        $common1[$r1]['billing_name'] = $users->billing_name;
    			        $common1[$r1]['billing_number'] = $users->billing_number;
    			        $common1[$r1]['billing_email'] = $users->billing_email;
    			        $common1[$r1]['billing_address'] = $users->billing_address;
    			        $common1[$r1]['provider_lat'] = $users->provider_lat;
    			        $common1[$r1]['provider_lng'] = $users->provider_lng;
    			        $common1[$r1]['order_lat'] = $users->order_lat;
    			        $common1[$r1]['order_lng'] = $users->order_lng;
    			        $common1[$r1]['billing_city'] = $users->billing_city;
    			        $common1[$r1]['billing_state'] = $users->billing_state;
    			        $common1[$r1]['billing_country'] = $users->billing_country;
    			        $common1[$r1]['billing_zipcode'] = $users->billing_zipcode;
    			        
    			        if(!empty($users->delivery_date_time)) 
    			        $deliveryDT = Carbon::parse($users->delivery_date_time)->format('Y-m-d');
    			        else
    			        $deliveryDT = null;
    			        
    			        if(!empty($users->accepted_date)) 
    			        $acceptedDT = Carbon::parse($users->accepted_date)->format('Y-m-d');
    			        else
    			        $acceptedDT = null;
    			        
    			        if(!empty($users->out_for_delivery_date)) 
    			        $outDT = Carbon::parse($users->out_for_delivery_date)->format('Y-m-d');
    			        else
    			        $outDT = null;
    			        
    			        if(!empty($users->delivered_at)) 
    			        $deliveredDT = Carbon::parse($users->delivered_at)->format('Y-m-d');
    			        else
    			        $deliveredDT = null;
    			        
    			        if(!empty($users->canceled_at)) 
    			        $canceledDT = Carbon::parse($users->canceled_at)->format('Y-m-d');
    			        else
    			        $canceledDT = null;
    			        
    			        if(!empty($users->refunded_at)) 
    			        $refDT = Carbon::parse($users->refunded_at)->format('Y-m-d');
    			        else
    			        $refDT = null;
    			        
    			        $common1[$r1]['delivery_date_time'] = $deliveryDT;
    			        $common1[$r1]['status'] = $users->status;
    			        $common1[$r1]['assign_driver_id'] = $users->assign_driver_id;
    			        $common1[$r1]['is_driver_accept'] = $users->is_driver_accept;
    			        $common1[$r1]['order_status'] = $users->order_status;
    			        $common1[$r1]['accepted_date'] = $acceptedDT;
    			        
    			        $common1[$r1]['out_for_delivery_date'] = $outDT;
    			        $common1[$r1]['delivered_at'] = $deliveredDT;
    			        $common1[$r1]['canceled_at'] = $canceledDT;
    			        $common1[$r1]['refunded_at'] = $refDT;
    			        $common1[$r1]['client_note'] = $users->client_note;
    			        $common1[$r1]['created_at'] = $users->created_at ? $users->created_at->toDateTimeString() : null;
    			        $common1[$r1]['updated_at'] = $users->updated_at ? $users->updated_at->toDateTimeString() : null;
    			        
    			        $common1[$r1]['user']['id'] = $users->user->id ?? null;
    			        $common1[$r1]['user']['name'] = $users->user->name ?? null;
    			        $common1[$r1]['user']['email'] = $users->user->email ?? null;
    			        $common1[$r1]['user']['mobile'] = $users->user->mobile ?? null;
    			        $common1[$r1]['user']['user_image'] = $users->user->user_image ?? null;
    			        $common1[$r1]['user']['lattitude'] = $users->user->lattitude ?? null;
    			        $common1[$r1]['user']['longitude'] = $users->user->longitude ?? null;
    			        $common1[$r1]['user']['address'] = $users->user->address ?? null;
    			        $common1[$r1]['user']['country'] = $users->user->country ?? null;
    			        $common1[$r1]['user']['state'] = $users->user->state ?? null;
    			        $common1[$r1]['user']['city'] = $users->user->city ?? null;
    			        $common1[$r1]['user']['zip'] = $users->user->zip ?? null;
    			        
    			        $common1[$r1]['provider']['id'] = $users->provider->id ?? null;
    			        $common1[$r1]['provider']['name'] = $users->provider->name ?? null;
    			        $common1[$r1]['provider']['email'] = $users->provider->email ?? null;
    			        $common1[$r1]['provider']['mobile'] = $users->provider->mobile ?? null;
    			        $common1[$r1]['provider']['user_image'] = $users->provider->user_image ?? null;
    			        $common1[$r1]['provider']['lattitude'] = $users->provider->lattitude ?? null;
    			        $common1[$r1]['provider']['longitude'] = $users->provider->longitude ?? null;
    			        //$common1[$r1]['provider']['cur_lat'] = $users->provider->cur_lat ?? null;
    			        //$common1[$r1]['provider']['cur_lng'] = $users->provider->cur_lng ?? null;
    			        $common1[$r1]['provider']['address'] = $users->provider->address ?? null;
    			        $common1[$r1]['provider']['country'] = $users->provider->country ?? null;
    			        $common1[$r1]['provider']['state'] = $users->provider->state ?? null;
    			        $common1[$r1]['provider']['city'] = $users->provider->city ?? null;
    			        $common1[$r1]['provider']['zip'] = $users->provider->zip ?? null;
    			    }
    		        $jsonArray['error']=false;
    		        $jsonArray['data']=$common1;
    			}
    			else
    			{
    				$jsonArray['error']=true;
    				$jsonArray['message']="You have not delivered any order!"; 
    			}
            }
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Driver Order Menu(Sidebar) 
|--------------------------------------------------------------------------
*/

public function api_driverOrderDeliveredHistory(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required',
        'user_id'	   => 'required', 
        'tab'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter role ID',
            'user_id.required' => 'Please enter user ID',
            'tab.required' => 'Please select tab',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            if($request->tab == 1)
            {
			    $orders = Order::with('user','provider','order_detail','order_detail.order_customisations')->whereDate('delivered_at', Carbon::today())->where('assign_driver_id',$request['user_id'])->where('order_status', 4)->get();
    			if(count($orders) > 0)
    			{
    		        $jsonArray['error']=false;
    		        $jsonArray['count']=count($orders);
    		        $jsonArray['data']=$orders;
    			}
    			else
    			{
    				$jsonArray['error']=true;
    				$jsonArray['count']=count($orders);
    				$jsonArray['message']="No todays order found!"; 
    			}
            }
            elseif($request->tab == 2)
            {
                $orders = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('delivered_at', '>', Carbon::now()->startOfWeek())->where('delivered_at', '<', Carbon::now()->endOfWeek())->where('assign_driver_id',$request['user_id'])->where('order_status', 4)->get();
			
    			if(count($orders) > 0)
    			{
    		        $jsonArray['error']=false;
    		        $jsonArray['count']=count($orders);
    		        $jsonArray['data']=$orders;
    			}
    			else
    			{
    				$jsonArray['error']=true;
    				$jsonArray['count']=count($orders);
    				$jsonArray['message']="You have not any order in this week!"; 
    			}
            }
            elseif($request->tab == 3)
            {
                $orders = Order::with('user','provider','order_detail','order_detail.order_customisations')->whereMonth('delivered_at', Carbon::now()->month)->where('assign_driver_id',$request['user_id'])->where('order_status', 4)->get();
			
    			if(count($orders) > 0)
    			{
    		        $jsonArray['error']=false;
    		        $jsonArray['count']=count($orders);
    		        $jsonArray['data']=$orders;
    			}
    			else
    			{
    				$jsonArray['error']=true;
    				$jsonArray['count']=count($orders);
    				$jsonArray['message']="You have not any order in this month!"; 
    			}
            }
            elseif($request->tab == 4)
            {
                $orders = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('delivered_at', '>', (new \Carbon\Carbon)->submonths(3))->where('assign_driver_id',$request['user_id'])->where('order_status', 4)->get();
			
    			if(count($orders) > 0)
    			{
    		        $jsonArray['error']=false;
    		        $jsonArray['count']=count($orders);
    		        $jsonArray['data']=$orders;
    			}
    			else
    			{
    				$jsonArray['error']=true;
    				$jsonArray['count']=count($orders);
    				$jsonArray['message']="You have not any order in last 3 months!"; 
    			}
            }
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Get Out for delivery Orders
|--------------------------------------------------------------------------
*/

public function api_ordersOutForDelivery(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required', 
        'user_id'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles id',
            'user_id.required' => 'Please enter user ID',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            $driver = User::where('id', $request->user_id)->where('roles_id', $request->roles_id)->first();
            if(!empty($driver))
            {
                $driverOrders = Order::with('provider:id,name,user_image,address,state,city,country,zip','order_detail','order_detail.order_customisations')->where('assign_driver_id', $request->user_id)->where('order_status', 3)->get();
                
                $jsonArray['error']=false;
                $jsonArray['count']=count($driverOrders);
    		    $jsonArray['data']=$driverOrders;               
    		        
            }
            else
            {
                $jsonArray['error']=true;
    			$jsonArray['message']="No driver found with this ID"; 
            }
            
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Rate Driver Profile
|--------------------------------------------------------------------------
*/
public function api_rateDriver(Request $request)
{
    try
	{
		$v = Validator::make($request->all(), [
			'roles_id' => 'required',
			'user_id' => 'required',
			'driver_id' => 'required',
			'rating' => 'required',
		],
		[
			'roles_id.required' => 'Please enter roles id',
		    'user_id.required' => 'You must login to rate this Driver!',
		    'driver_id.required' => 'Please specify Driver Id',
		    'rating.required' => 'Please enter rating',
		]);
		if ($v->fails())
		{
			$jsonArray['error']=true;
			$jsonArray['message']=$v->messages()->first();           
		}
		else 
		{
            $user=User::where('id',$request['user_id'])->where('roles_id', 2)->first();
            $driverID=User::where('id',$request['driver_id'])->where('roles_id', 4)->first();
            
            $rateDriver = RateDriver::where('user_id', $request['user_id'])->where('driver_id', $request['driver_id'])->first();
            if(!empty($user) && !empty($driverID))
            {
                if(count($rateDriver) == 0)
                {
                    $rating = new RateDriver;
                    $rating->user_id=$request['user_id'];
                    $rating->driver_id=$request['driver_id'];
                    $rating->rating=$request['rating'];
                    $rating->save();
                    
                    $jsonArray['error']=false;
                    $jsonArray['message']="You have rated this driver";
                }
                else
                {
                    RateDriver::where('user_id', $request['user_id'])->where('driver_id', $request['driver_id'])->update(['rating' => $request['rating']]);
                    $jsonArray['error']=false;
                    $jsonArray['message']="Your rating has been updated";
                }
            }
            else 
            {
                $jsonArray['error']=true;
                $jsonArray['message']="Invalid User Id or Driver ID";
            }
        }
	}
    catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']="Something Went Wrong!!!";
	}    
    return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Track Order
|--------------------------------------------------------------------------
*/

public function api_trackOrder(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required', 
        'user_id'	   => 'required',
        'order_id'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles id',
            'user_id.required' => 'Please enter user ID',
            'order_id.required' => 'Please enter order ID',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            $user = User::where('id', $request->user_id)->where('roles_id', $request->roles_id)->first();
            if(!empty($user))
            {
                $order = Order::where('id', $request->order_id)->first();
                
                if($order->order_status == 3)
                {
                    $driverID = $order->assign_driver_id;
                    //UserDocument::where('user_id',$driverID)->first();
                    $driverProfile = User::select(['id','name','user_image','vehicle_number','mobile','cur_lat','cur_lng'])->where('id', $driverID)->first();
                    
                    $jsonArray['error']=false;
    		        $jsonArray['data']=$driverProfile;
    		        $jsonArray['order_data']=$order;
                }
                else
                {
                    $jsonArray['error']=false;
    		        $jsonArray['order_data']=$order;
                }
                  
            }
            else
            {
                $jsonArray['error']=true;
    			$jsonArray['message']="No user found with this ID"; 
            }
            
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}


/*
|--------------------------------------------------------------------------
| API Update Driver Lat Long
|--------------------------------------------------------------------------
*/

public function api_updateDriverLatlong(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required', 
        'user_id'	   => 'required',
        'current_lattitude'	   => 'required',
        'current_longitude'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles id',
            'user_id.required' => 'Please enter user ID',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            $driver = User::where('id', $request->user_id)->where('roles_id', $request->roles_id)->first();
            if(!empty($driver))
            {
                $driver->cur_lat = $request->current_lattitude;
                $driver->cur_lng = $request->current_longitude;
                $driver->save();
                
                $driverProfile = User::select(['id','name','email','mobile','user_image','roles_id','cur_lat','cur_lng'])->where('id', $request->user_id)->where('roles_id', $request->roles_id)->first();
                
                $jsonArray['error']=false;
    		    $jsonArray['data']=$driverProfile;               
    		        
            }
            else
            {
                $jsonArray['error']=true;
    			$jsonArray['message']="No driver found with this ID"; 
            }
            
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Accept Order
|--------------------------------------------------------------------------
*/

public function api_acceptOrder(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required', 
        'user_id'	   => 'required',
        'order_id'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles id',
            'user_id.required' => 'Please enter user ID',
            'order_id.required' => 'Please enter order ID',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            $order = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('id', $request->order_id)->where('order_status', 1)->first();
            if(!empty($order))
            {
                $order->is_driver_accept = 1;
                $order->order_status = 2;
                $order->accepted_date = Carbon::now();
                $order->save();
                
                $user = User::where('id', $order->user_id)->first();
                
                if(!empty($user->device_token))
                {
                    $title = 'Your order has been accepted';
                    $this->sendOrderAcceptNotification($title, $user->device_token, $order);
                }
                
                $orderData = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('id', $request->order_id)->first();
                
                $jsonArray['error']=false;
                $jsonArray['message']="The order has been accepted!";
    		    $jsonArray['data']=$orderData;               
    		        
            }
            else
            {
                $jsonArray['error']=true;
    			$jsonArray['message']="Invalid order ID"; 
            }
            
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Deliver Order
|--------------------------------------------------------------------------
*/

public function api_outForDelivery(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required', 
        'user_id'	   => 'required',
        'order_id'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles id',
            'user_id.required' => 'Please enter user ID',
            'order_id.required' => 'Please enter order ID',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            $order = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('id', $request->order_id)->where('is_driver_accept', 1)->where('assign_driver_id', $request->user_id)->where('order_status', 2)->first();
            if(!empty($order))
            {
                $order->order_status = 3;
                $order->out_for_delivery_date = Carbon::now();
                $order->save();
                
                $user = User::where('id', $order->user_id)->first();
                
                if(!empty($user->device_token))
                {
                    $title = 'Your order is now out for the delivery';
                    $this->sendOrderOutForDeliveryNotification($title, $user->device_token, $order);
                }
                
                $orderData = Order::where('id', $request->order_id)->first();
                
                $jsonArray['error']=false;
                $jsonArray['message']="The order is now out for the delivery!";
    		    $jsonArray['data']=$orderData;               
    		        
            }
            else
            {
                $jsonArray['error']=true;
    			$jsonArray['message']="Invalid order ID"; 
            }
            
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Deliver Order
|--------------------------------------------------------------------------
*/

public function api_deliverOrder(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required', 
        'user_id'	   => 'required',
        'order_id'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles id',
            'user_id.required' => 'Please enter user ID',
            'order_id.required' => 'Please enter order ID',
        ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
            $order = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('id', $request->order_id)->where('is_driver_accept', 1)->where('assign_driver_id', $request->user_id)->where('order_status', 3)->first();
            if(!empty($order))
            {
                $order->order_status = 4;
                $order->delivered_at = Carbon::now();
                $order->save();
                
                $user = User::where('id', $order->user_id)->first();
                
                if(!empty($user->device_token))
                {
                    $title = 'Your order has been delivered successfuly';
                    $this->sendOrderDeliverNotification($title, $user->device_token, $order);
                }
                
                $orderData = Order::where('id', $request->order_id)->first();
                
                $jsonArray['error']=false;
                $jsonArray['message']="The order has been delivered!";
    		    $jsonArray['data']=$orderData;               
    		        
            }
            else
            {
                $jsonArray['error']=true;
    			$jsonArray['message']="Invalid order ID"; 
            }
            
				
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Save Card
|--------------------------------------------------------------------------
*/

public function api_saveCard(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required',
        'user_id'	   => 'required', 
        'name_on_card'	       => 'required',
        'card_number'     => 'required',          
        'expire_month'     => 'required',
        'expire_year'     => 'required',
        'card_cvv'     => 'required',
        'card_type'     => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles ID',
            'user_id.required' => 'Please enter user ID',
            'name_on_card.required' => 'Please enter name mention on your card',
            'card_number.required' => 'Please enter card number',
            'expire_month.required' => 'Please enter expire month of your card',
            'expire_year.required' => 'Please enter expire year of your card',
            'card_cvv.required' => 'Please enter CVV of your card',
            'card_type.required' => 'Please select card type',
            ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
			$user=User::where('id',$request['user_id'])->where('roles_id', $request['roles_id'])->first();
			
			if(!empty($user))
			{
				$userCard=new Card;
                $userCard->user_id=$request['user_id'];
                $userCard->card_type=$request['card_type'];
                $userCard->name_on_card=$request['name_on_card'];
                $userCard->card_number=$request['card_number'];
                $userCard->expire_month=$request['expire_month'];
                $userCard->expire_year=$request['expire_year'];
                $userCard->card_cvv=$request['card_cvv'];
                $userCard->save();
                
               
                $jsonArray['error']=false;
				$jsonArray['message']="A new card has been added"; 
				 	
			}
			else
			{
				$jsonArray['error']=true;
				$jsonArray['message']="Invalid User"; 
			}	
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
} 

/*
|--------------------------------------------------------------------------
| API Save Card
|--------------------------------------------------------------------------
*/

public function api_editCard(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required',
        'user_id'	   => 'required', 
        'card_id'	   => 'required',
        'name_on_card'	       => 'required',
        'card_number'     => 'required',          
        'expire_month'     => 'required',
        'expire_year'     => 'required',
        'card_cvv'     => 'required',
        'card_type'     => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles ID',
            'user_id.required' => 'Please enter user ID',
            'card_id.required' => 'Please select a card',
            'name_on_card.required' => 'Please enter name mention on your card',
            'card_number.required' => 'Please enter card number',
            'expire_month.required' => 'Please enter expire month of your card',
            'expire_year.required' => 'Please enter expire year of your card',
            'card_cvv.required' => 'Please enter CVV of your card',
            'card_type.required' => 'Please select card type',
            ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
			$user=User::where('id',$request['user_id'])->where('roles_id', $request['roles_id'])->first();
			$userCard=Card::where('id',$request['card_id'])->where('user_id', $request['user_id'])->first();
			if(!empty($user) && !empty($userCard))
			{
                $userCard->card_type=$request['card_type'];
                $userCard->name_on_card=$request['name_on_card'];
                $userCard->card_number=$request['card_number'];
                $userCard->expire_month=$request['expire_month'];
                $userCard->expire_year=$request['expire_year'];
                $userCard->card_cvv=$request['card_cvv'];
                $userCard->save();
                
               
                $jsonArray['error']=false;
				$jsonArray['message']="Card details has been updated"; 
				 	
			}
			else
			{
				$jsonArray['error']=true;
				$jsonArray['message']="Invalid User"; 
			}	
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Delete Card
|--------------------------------------------------------------------------
*/

public function api_deleteCard(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required',
        'user_id'	   => 'required', 
        'card_id'	   => 'required',
        ],
        [
            'roles_id.required' => 'Please enter roles ID',
            'user_id.required' => 'Please enter user ID',
            'card_id.required' => 'Please select a card',
            ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
			$user=User::where('id',$request['user_id'])->where('roles_id', $request['roles_id'])->first();
			$userCard = Card::where('user_id', $request['user_id'])->where('id', $request['card_id'])->first();
			if(!empty($user) && !empty($userCard))
			{
				$userCarddlt = Card::where('user_id', $request['user_id'])->where('id', $request['card_id'])->delete();
                
                if($userCarddlt == 1)
                {
                    $jsonArray['error']=false;
				    $jsonArray['message']="The card has been deleted";
                }
                else
                {
                    $jsonArray['error']=true;
				    $jsonArray['message']="This card does not exist!";
                }
			}
			else
			{
				$jsonArray['error']=true;
				$jsonArray['message']="Invalid User"; 
			}	
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

/*
|--------------------------------------------------------------------------
| API Get Saved Cards
|--------------------------------------------------------------------------
*/

public function api_getSavedCards(Request $request)
{
    try
    {
        $validation = Validator::make($request->all(), [
        'roles_id'	   => 'required',
        'user_id'	   => 'required', 
        ],
        [
            'roles_id.required' => 'Please enter roles ID',
            'user_id.required' => 'Please enter user ID',
            ]);
        if ($validation->fails()) 
        {
			$jsonArray['error']=true;
			$jsonArray['message']=$validation->messages()->first();
        }
        else
        {
			$user=User::where('id',$request['user_id'])->where('roles_id', $request['roles_id'])->first();
			$userCard = Card::where('user_id', $request['user_id'])->get();
			if(!empty($user))
			{
			    if(count($userCard) > 0)
			    {
			        $jsonArray['error']=false;
			        $jsonArray['data']=$userCard;
			    }
			    else
			    {
			        $jsonArray['error']=true;
			        $jsonArray['message']="No cards found";
			    }
                
			}
			else
			{
				$jsonArray['error']=true;
				$jsonArray['message']="Invalid User"; 
			}	
	    }
	}
	catch(Exception $e)
	{
		$jsonArray['error']=true;
		$jsonArray['message']=$e->getMessage();
	}
return response()->json($jsonArray);
}

public function apiTestUpload()
    {   
        if(!empty($_GET['url']))
        {
            $url = $_GET['url'];
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            $urlPath = 'storage/app/'.$name;
            Storage::put($name, $contents);
        
            
            $jsonArray['error']=false;
            $jsonArray['message']="Uploaded!";
        }
        else
        {
            $jsonArray['error']=true;
            $jsonArray['message']="URL Not Found!";
        }
        return response()->json($jsonArray);
    }


/*
|--------------------------------------------------------------------------
| API Logout
|--------------------------------------------------------------------------
*/
    public function api_logout(Request $request)
    {
        try
        {
            $validation = Validator::make($request->all(), [
            'roles_id'	   => 'required',
            'user_id'	   => 'required', 
            ],
            [
                'roles_id.required' => 'Please enter roles ID',
                'user_id.required' => 'Please enter user ID',
                ]);
            if ($validation->fails()) 
            {
    			$jsonArray['error']=true;
    			$jsonArray['message']=$validation->messages()->first();
            }
            else
            {
                $user=User::where('id',$request['user_id'])->where('roles_id',$request['roles_id'])->first();
                if(!empty($user))
                {
                    $user->device_token=null;
                    $user->device_type=null;
                    $user->save();
                    $jsonArray['error']=false;
                    $jsonArray['message']="Logout successfully";
                }
                else 
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Invalid User Id";
                }
            }
        }
        catch(Exception $e)
    	{
    		$jsonArray['error']=true;
    		$jsonArray['message']=$e->getMessage();
    	}
        return response()->json($jsonArray);
    }
    

 
// =============================================================================
// ========================== Taxi Booking Notification Android  ===============
    public function new_booking_notification_android($tokens,$title,$booking_details)
    {   
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $jsonArray['result']=$booking_details;
        $jsonArray['result']->title=$title;
        
        $tok=array();
        $notify=array();
        if(!empty($tokens))
        {
            if(count($tokens)>0)
            {
                foreach($tokens as $token)
                {
                    array_push($tok,$token->device_token);
                }
            }
        }
        $fcmNotification = [
            'registration_ids' => $tok, //multple token array
            'data' => $jsonArray
        ];
        $headers =[
            'Authorization: key=AAAAKqjUV_0:APA91bHT0Ktkrx8ojjKPVuDtf3kdaKeiRZ7LwWo1X3wfJJOEDJ2lIGWiH-qGh3qs6uupkgOmKcrCiELPWFVywqIYJZzcNlZUGg-6SGsKF3quE31_mTzOfngwKQVcpYLDFlOc3-e7oTy_',//.$this->fcm_key_business_android,//AAAAu0eqOAg:APA91bGCcy1meCwMFJce7lxyiKg7UVckeacdWB7RAQWAHTpK3YW0OEECGIZlUXAzriK-Mld_aP7AfoCbxmx1N3CUZ8L0YgCmihffVAvtpfYQ4XXzKkklLhUEA6TV3Fnuu7GRKauvgHDd',
            'Content-Type: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    }
    
// =============================================================================
// ========================== Taxi Booking Notification IOS  ===================
    public function new_booking_notification_ios($tokens,$title,$booking_details)
    {   
        $jsonArray['result']=$booking_details;
        $jsonArray['result']->title=$title;
        
        //$extraNotificationData = ["message" => $jsonArray,"moredata" =>'dd'];
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey ='AAAAOmS_yxo:APA91bGlNzwgR5xWZaWEfVkxYUV2IeejCKaYN0uD-yjqDiWPF4eRaUfP-t5OF1ZFS3G38oS11CXIlTGlpmKkilZTcqzawUvPcdPKKCdB7S0o5oUVQ2ExVY7wltId5DMnnKmTa79QOleO';//$this->fcm_key_business_ios;//'AAAAkv9Uqy0:APA91bFDwcsZYPDSt-1g4BSsL-WIuxerEtACH5l_D9dCLdKFE72lRTyoHY8UDzxIqgrEwI9dnXdfVqw-aQTiyTMloBdGKrdY1PEp54VwYJljfLnelj2uogriaOLvQzJ1vaqegePnPwAV';
        
        // AAAAOmS_yxo:APA91bFqhIv1YcyNiaEwNHCsUQERZBVOE59VqlavKiywUVPC_c0xTVUldg_HfDCi27Eq-xptc-tvRLOUQW0_UphfQSiWXjqOZOLIa3RugmX07ftdgigUS-29bXjV-2YfTXkXHHFKTHX1
        $body = "New Booking Request.";
        $notification = array('title' =>$title , 'data' => $jsonArray, 'sound' => 'default', 'badge' =>'1');
        
        $tok=array();
        $notify=array();
        if(!empty($tokens))
        {
            if(count($tokens)>0)
            {
                foreach($tokens as $token)
                {
                    array_push($tok,$token->device_token);
                }
            }
        }
        $arrayToSend = array('registration_ids' => $tok, 'notification'=>$notification,'priority'=>'high');
        $fcmNotification = [
                'registration_ids' => $tok, //multple token array
                //'to'        => $token, //single token
                'data' => $jsonArray,
            ];
            
        $json = json_encode($arrayToSend);//json_encode($fcmNotification);//
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        return $result;    
    }
    
 public function api_test()
    {
        $test=Test::where('id','1')->increment('count');
        if($test>0)
        {
            $jsonArray['error']=false;
            $jsonArray['updated']="Updated";
        }
        else
        {
            $jsonArray['error']=false;
            $jsonArray['messaged']="Updated";
        }
        return response()->json($jsonArray);
    }
    
    public function api_check()
    {
        $test=Test::where('id','1')->first();
        
        $jsonArray['error']=false;
        $jsonArray['result']=$test;
         
        return response()->json($jsonArray);
    }
    
    public function api_assignDriverUsingLink()
    {
        $jsonArray['message']="";
        
        if(empty($_GET['mobile']))
        {
            $jsonArray['error']=true;
            $jsonArray['message']="Please enter mobile number";
        }
        if(empty($_GET['orderID']))
        {
            $jsonArray['error']=true;
            $jsonArray['message']="Please enter order ID";
        }
        if(empty($jsonArray['message']) == true)
        {
            $test=User::where('mobile', $_GET['mobile'])->where('roles_id', 4)->first();
            
            if(!empty($test))
            {
                if($test->admin_approval == 0)
                {
                    $jsonArray['error']=true;
                    $jsonArray['message']="Driver account is pending for approval!!";
                }
                else
                {
                    $ordst = Order::with('user','provider','order_detail','order_detail.order_customisations')->where('id', $_GET['orderID'])->where('assign_driver_id',0)->first();
                    if(!empty($ordst))
                    {
                        $order=Order::where('id', $_GET['orderID'])->update(['assign_driver_id' => $test->id, 'order_status' => 1, 'is_driver_accept' => 0]);
                        $user = User::where('id', $test->id)->first();
                        
                        if(!empty($user->device_token))
                        {
                            $title='Here is a new order!!';
                            $this->sendOrderNotificationToDriver($title, $user->device_token, $ordst);
                        }
                        
                        
                        $jsonArray['error']=false;
                        $jsonArray['message']="Driver Assigned!!";
                    }
                    else
                    {
                        $jsonArray['error']=true;
                        $jsonArray['message']="The order has already been assigned to other driver!";
                    }
                    
                }
                
            }
            else
            {
                $jsonArray['error']=true;
                $jsonArray['message']="Something went wrong!!";
            }
            
        }
        
        return response()->json($jsonArray);
    }

  
}
