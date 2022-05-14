<?php

namespace App\Http\Controllers;

use App\Page;
use App\Service;
use App\ServiceCategory;
use App\Smartblock;
use App\Blog;
use App\Banner;
use App\State;
use App\SiteSetting;
use App\FrontMenu;
use App\SpecializeBusiness;
use App\BusinessMedia;
use App\Testimonial;
use App\Comment;
use App\User;
use App\Contact;
use App\BusinessService;
use App\UserDocument;
use App\Review;
use App\Unit;
use App\SpecialServiceCategory;
use App\City;
use Mail;
use App\Mail\SendEmail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Hash;
use DB;

//use App\State;

use Session;
use Illuminate\Http\Request;

class HodController extends Controller
{


/*
|**********************************************************************
|           Reset password for Mobile APP
|**********************************************************************
*/
    
    public function reset_password($email)
    { 
        //$this->gettopmenu();   
        //$this->getSiteInfo();
        //$this->quicklinks();
        //$this->allpages();
        
        if(!empty($email))
        {
           return view('homepages.reset_password')
            		->with('email',$email);
        }
        else
        {
            return redirect('/');//->back();
        }
    }
    public function store_password(Request $request)
    {
        
        if(empty($request['password']))
        {
            Session::flash('error_message','Please Enter Password');    
            return back();   
        }
        else if(strlen($request['password'])<6)
        {
            Session::flash('error_message','Password Should Be More 6 Digits');
            return back();
        }
        else if(empty($request['confirm_password']))
        {
            Session::flash('error_message','Please Enter Confirm Password');    
            return back();
        }
        else
        {
            if($request['password']!=$request['confirm_password'])
            {
                Session::flash('error_message','Confirm Password Not Matched');    
                return back();
            }
            else
            {
                
                
                $user=User::where('email',base64_decode($request['email']))->first();
                
                if(!empty($user))
                {
                    
                    //$user->password=Hash::make($request['password']);
					$user->password=md5($request['password']);
					$user->txtpassword=$request['password'];
                    $user->save();
                    Session::flash('success_message','Password updated successfully');
                    return back();
                }
                else
                {
                    Session::flash('error_message','Something Went Wrong');   
                    return redirect('login');
                }
            }
        }
    }
    
}