<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\SiteSetting;
use App\State;
use App\City;
use App\Banner;
use App\Page;
use App\ServiceCategory;
use App\Service;
use App\Smartblock;
use App\Blog;
use App\SpecializeBusiness;
use App\RateDriver;
use App\Payment;
use App\Review;
use App\Booking;
use App\Quote;
use App\Subscription;
use Carbon\Carbon;
use App\UserDocument;
use App\UserAddress;
use App\Company;
use Validator;
use Illuminate\Http\Request;
use Session; 

use Mail;
use App\Mail\SendQuote;

use App\Mail\SendEmail;
use App\Mail\EmailVerify;   //send email verify emails
use DB;
use Auth;

class UsersController extends Controller
{
    
/*
*=============== all Get methods ================= 
*/
	public function getMethods($method='')
	{
     
		if(!empty($method))
    {
      $status=$this->verify();
      if($status==true)
      {
        return $this->getRequestedPage($method);
      }
      else
      {
        return redirect('login');
      }
    }
    else
    {
      $status=$this->verify();
      if($status==true)
      {
        return redirect('users/profile');
      }
      else
      {
      return redirect('login');
      }
    }
    
  }
  public function postMethods(Request $request,$method='')
  {
    switch($method)
    {
      case 'change-password':
        return $this->change_password($request);
      break;
      case 'login':
        return $this->login($request);
      break;
      case 'write-a-review':
        return $this->store_review($request);
      break;
      case 'get-a-quote':
        return $this->store_quote($request);
      break;
      case 'signup':
        return $this->signup($request);
      break;
      case 'profile':
        return $this->profile_update($request);
      break;
      case 'become-a-provider':
        return $this->create_provider_profile($request);
      break;
      case 'verify-otp':
        return $this->verify_otp($request);
      break;
      case 'add-address':
          return $this->save_address_user($request);
      break;
      case 'update-address':
        return $this->update_address_user($request);
      break;
      case 'remove-address':
          return $this->remove_address_user($request);
          break;

    }
    return $this->$method($request);
  }

  public function verify()
  {
    if(Session::has('bu_user_info'))
      {
        if(Session::get('bu_user_info')->roles_id == 1 || Session::get('bu_user_info')->roles_id == 3)
        {
          return true;
        }
      }
      return false;
  }

  public function getRequestedPage($slug)
  {
      switch($slug)
      {
        case 'password':
          return $this->password();
        break;

        case 'profile':
          return $this->profile();
        break;

        case 'my-booking':
          return $this->my_booking_user();
        break;

        case 'booking-details':
        return $this->booking_details();
        break;

        case 'write-a-review':
          return $this->write_a_review(); 
        break;

        case 'review-rating':
          return $this->review_rating();
        break;
        case 'get-a-quote':
          return $this->get_a_quote();  //view
        break;
        case 'become-a-provider':
          return $this->become_an_provider();
        break;
        case 'requested-quotes':
            return $this->sended_quotes();
        break;
        case 'quote-details':
            return $this->quote_details_user();
            break;
        case 'add-address':
            return $this->add_address_user();
            break;
        case 'address-details':
            return $this->address_details();
            break;
        case 'make-primary':
            return $this->make_primary();
            break;
         
      }  
  }
  public function update_image(Request $request)
  {
      $target='siteimages/Users/';
      $header_logo=$request->file('profile_image');
      
      if(!empty($header_logo))
      {
        $headerImageName=$header_logo->getClientOriginalName();
        $ext1=$header_logo->getClientOriginalExtension();
        $temp1=explode(".",$headerImageName);
        $newHeaderLogo='user'.rand()."".round(microtime(true)).".".end($temp1);
        $headerTarget='siteimages/Users/'.$newHeaderLogo;
        $header_logo->move($target,$newHeaderLogo);
       
       
      $useremail=Session::get('useremail');
      $userdata=User::where('email',$useremail)->where('status','1')->first();
      if(!empty($userdata))
      {
        $userdata->user_image=$headerTarget;
        Session::put('profile_image',$headerTarget);
        $userdata->save();
      }
    }
    //return redirect('users/profile');
    return redirect()->back();
  }
  public function password()
  { 
    if(!Session::has('topmenus'))
        {
 
         PropertymdController::gettopmenu();   
         PropertymdController::getSiteInfo();
         PropertymdController::quicklinks();
         PropertymdController::allpages();
        } 

        $useremail=Session::get('useremail');
        $userdata=User::where('email',$useremail)->where('status','1')->first();
        //$topmenus=PropertymdController::gettopmenu();
        //$siteInfo=PropertymdController::getSiteInfo();
        //$quicklinks=PropertymdController::quicklinks();
        //$pages=Page::where('status','1')->get();
        $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);

      return view('users.change_password')
            //->with('siteInfo',$siteInfo)
            //->with('topmenus',$topmenus)
           // ->with('quicklinks',$quicklinks)
           // ->with('pages',$pages)
            ->with('blogs',$blogs);
  }
  public function change_password(Request $request)
  {
     $v = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required',  
              ],
            [
              'old_password.required'=>'Old password field required',
              'new_password.required'=>'New password required',
              'new_password.min'=>'New password must be atleast 8 digits long',
              'confirm_password.required'=>'Confirmed password required',
              
                    ]);
    if ($v->fails())
      {

      return redirect()->back()->withInput($request->input())->withErrors($v->errors());
      }
    else if($request['new_password']!=$request['confirm_password'])
    {
        Session::flash('error_message','Confirm password does not matched');
        return redirect('users/password');
    }
    else
    {


      $old_pass=$request['old_password'];
      $new_pass=$request['new_password'];
      $confirmed_password=$request['confirm_password'];
       
        //$useremail=Session::get('userid');
          $userdata=User::where('id',Session::get('userid'))->where('password',md5($old_pass))->where('status','1')->first();
          if(!empty($userdata))
          {
            $userdata->password=md5($new_pass);
            $userdata->txtpassword=$new_pass;
            $userdata->save();
            Session::flash('success_message', 'Password changed Successfully!');
          }
          else
          {
            Session::flash('error_message', 'Invalid Password!');
          }
       
    }
    return redirect('users/password');
    //return redirect('users/password')->back()->withInput($request->input())->withErrors($v->errors());
   

  }
  public function profile()
    {
       
         PropertymdController::gettopmenu();   
         PropertymdController::getSiteInfo();
         PropertymdController::quicklinks();
         PropertymdController::allpages();
         
         
        $userdata=User::where('id',Session::get('userid'))->where('status','1')->first();
        //$topmenus=PropertymdController::gettopmenu();
        //$siteInfo=PropertymdController::getSiteInfo();
        //$quicklinks=PropertymdController::quicklinks();
       // $pages=Page::where('status','1')->get();
        //$address=UserAddress::where('user_id',Session::get('userid'))->where('primary_status','1')->first();
        $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
        $states=State::where('status','1')->orderBy('name','ASC')->get();
        
        $cities=City::where('state_id',$userdata->state_id)
                      ->where('status','1')->get();   
      return view('users.userprofile')
           // ->with('siteInfo',$siteInfo)
           // ->with('topmenus',$topmenus)
            //->with('quicklinks',$quicklinks)
           // ->with('pages',$pages)
            ->with('blogs',$blogs)
            ->with('states',$states)
            ->with('cities',$cities)
            ->with('userdata',$userdata)
            //->with('address',$address)
            ;
    }
    public function profile_update(Request $request)
    {  return 
        $v = Validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                    'email' => 'required|max:255',
                    //'mobile'=>'required',
                    //'state_id'=>'required',
                    //'city_id'=>'required',
                    'mobile' => 'required',
                    'mobile' => 'required|size:10',
                     ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        else
        {
          $useremail=Session::get('useremail');
          $userdata=User::where('email',$useremail)->where('status','1')->first();
          if(!empty($userdata))
          {
             $userdata->first_name=$request['first_name'];
            $userdata->last_name=$request['last_name'];
            $userdata->name=$request['first_name'].' '.$request['last_name'];
            $userdata->email=$request['email'];
            $userdata->mobile=$request['mobile'];
            $userdata->address=$request['address'];
            $userdata->latitude=$request['latitude'];
            $userdata->longitude=$request['longitude'];
            $userdata->state_id=$request['state_id'];
            $userdata->city_id=$request['city_id'];
            $userdata->save();
            
            $property=UserAddress::where('user_id',Session::get('userid'))->where('primary_status','1')->first();
            if(empty($property))
            {
                $property=new UserAddress;
            }
                $property->address=$request['address'];
                $property->latitude=$request['latitude'];
                $property->longitude=$request['longitude'];
                $property->city_id=$request['city_id'];
                $property->state_id=$request['state_id'];
                $property->primary_status=1;
                $property->user_id=Session::get('userid');
                $property->save();
             
            Session::flash('success_message', 'Profile Updated Successfully!');
          }
           
             
        }

        return redirect('users/profile');
    }

    public function logout($id='')
    {
    	 
        $role=Session::get('bu_user_info');
      
    
    Session::flush();  

		if($role->roles_id == 1 || $role->roles_id == 3)
		{
			return redirect('admin');
  	    }
		else
		{
		return redirect('login');
		} 
 
    }

/*
*====================== All Admin Methods Starts ============================= 
*/
    public function adminlogin(Request $request)
    {
        $validatedData = $request->validate([
		   'email' => 'required|email',
		   'password' => 'required',
        ],
    	[
    	 'email.required' => 'Please enter email address.',
    	 'email.email' => 'Please enter valid email address.', 
    	 'password.required' => 'Please enter password.',
    	]);
    	
    	$rememberToken = $request->password;
	   if(Auth::guard('web')->attempt(['email' =>$request->email,'password'=>$request->password]))
	   {
		 $UserID =  Auth::user()->id;
		 if(!empty($UserID))
		 {
		    $site_data = SiteSetting::where('id',1)->first();
		    if(Auth::user()->roles_id == 1)
			{
				Session::put('bu_user_info',Auth::user());
				Session::put('site_data',$site_data);
                return redirect('admin/dashboard');
			}
			elseif(Auth::user()->roles_id == 3)
			{
			    if(Auth::user()->admin_approval == 0)
			    {
			        Session::flash('error_message','Your account is pending for approval!');
                    return redirect('admin');
			    }
			    else
			    {
			        Session::put('bu_user_info',Auth::user());
    				Session::put('site_data',$site_data);
                    return redirect('admin/dashboard');
			    }
			}
            else
            {
              Session::flash('error_message','Invalid Email or Password!');
              return redirect('admin');
            }
		     
		     
		     
// 		     $status = Auth::user()->status;
// 		     if($status == 1)
// 			 {
// 				$site_data = SiteSetting::where('id',1)->first();
// 				Session::put('bu_user_info',Auth::user());
// 				Session::put('site_data',$site_data);
//                 return redirect('admin/dashboard');
// 			}
//             else
//             {
//               Session::flash('error_message','Invalid Email or Password!');
//               return redirect('admin');
//             }
		 }
		 else
		 {
		    Session::flash('error_message', 'Invalid Email or Password!');
            return redirect('admin'); 
		 }
	   }
	   else
        {
          Session::flash('error_message','Invalid Email or Password!');
          return redirect('admin');
        }
        
        /*
        $user_data = User::where('email',$request['email'])->where('password',md5($request['password']))->first();
		$site_data = SiteSetting::where('id',1)->first();
		if(!empty($user_data))
		{ 
			if($user_data->roles_id == 1)
			{
				Session::put('bu_user_info',$user_data);
				Session::put('site_data',$site_data);
                return redirect('admin/dashboard');
			}
			elseif($user_data->roles_id == 3)
			{
			    if($user_data->status == 0)
			    {
			        Session::flash('error_message','Your account is currently inactive!');
                    return redirect('admin');
			    }
			    else
			    {
			        Session::put('bu_user_info',$user_data);
    				Session::put('site_data',$site_data);
                    return redirect('admin/dashboard');
			    }
			}
            else
            {
              Session::flash('error_message','Invalid Email or Password!');
              return redirect('admin');
            }
        }
        else
        {
			
            Session::flash('error_message', 'Invalid Email or Password!');
            return redirect('admin');
        }
        */
	}

/*
*====================== Driver method ============================= 
*/

public function driverList()
    {
        try
        {
            $users = User::where('roles_id', 4)->orderBy('id','DESC')->paginate(20);
	        return view('admin.user.drivers.drivers_list',compact('users'));
        }
        catch(Exception $e)
        {
            return  $e->getMessage();// "Somthing Went Wrong!!!";
        }
    }
    
public function driverProfile($id='')
    { 
        $user = User::with('roles')->where('id',$id)->first();
        $rating=RateDriver::where('driver_id', $id)->avg('rating');
        return view('admin.user.drivers.show_driver_profile',compact('user','rating'));
    }    
    
    
     public function search_drivers()
    {  
        if(!empty($_GET['search']))
          {
                $products=User::where('roles_id', 4)->where(function($q) {
                                $q->where('name','like','%'.$_GET['search'].'%')
                                ->orWhere('email','like','%'.$_GET['search'].'%')
                                ->orWhere('mobile','like','%'.$_GET['search'].'%')
                                ;
                            })->get();
                
          }
          else
          {
              $products=User::where('roles_id', 4)->orderBy('id','DESC')->get();
          }
        
          foreach($products as $product)
          {

            echo '<tr>
            <td scope="col">
            <input type="checkbox" class="check_box" name="mul_del[]" id="mul_del[]" value="'.$product->id.'" /></td>
            
            <td>'.$product->name.'</td>
                       <td>'.$product->email.'</td>
                       <td>'.$product->mobile.'</td>
                          
            <td>
                <a href="javascript:" onclick="update_account_status('.$product->id.','.abs($product->admin_approval-1).')">
                    <span class="label '; if($product->admin_approval!='0') { echo 'label-success'; } else { echo 'label-strictwarning'; } echo '">';
                        if($product->admin_approval=='1') { echo 'Verified Account'; } else { echo 'Pending'; } 
                    echo '</span>
            </a>
            </td>                                 
                      <td>
          
              <a href="javascript:" onclick="update_status('.$product->id.','.abs($product->status-1).')">
                    <span class="label ';if($product->status!='0') { echo 'label-success'; } else { echo 'label-warning'; } echo '">';
                        if($product->status=='1') { echo 'Active';} else { echo 'Inactive';}
                    echo '</span>
                </a>
            </td>';
			
    
            
            
			echo '<td><a title="View Profile" href="'.url('admin/drivers/view-profile',[$product->id]).'"><i class="fa fa-desktop"></i></a>';
            echo '</tr>';
                                         
        }
    }
    
    
public function updatedriversstatus()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = User::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
        //return redirect('admin/menu');
	}
	public function updateDriverInspection()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = User::find($id);
        if($model) 
        {
            $model->admin_approval = $status;
            $model->save();
        }
        //return redirect('admin/menu');
	}    
    

/*
*====================== Userlist method ============================= 
*/

    public function search_app_user()
    {  
        if(!empty($_GET['search']))
          {
                $products=User::where('roles_id', 2)->where(function($q) {
                                $q->where('name','like','%'.$_GET['search'].'%')
                                ->orWhere('email','like','%'.$_GET['search'].'%')
                                ->orWhere('mobile','like','%'.$_GET['search'].'%')
                                ;
                            })->get();
                
          }
          else
          {
              $products=User::where('roles_id',2)->orderBy('id','DESC')->get();
          }
        
          foreach($products as $product)
          {

            echo '<tr>
            <td scope="col">
            <input type="checkbox" class="check_box" name="mul_del[]" id="mul_del[]" value="'.$product->id.'" /></td>
            
            <td>'.$product->name.'</td>
                       <td>'.$product->email.'</td>
                       <td>'.$product->mobile.'</td>
            
            
            
                                             
            <td>
              <a href="javascript:" onclick="update_status('.$product->id.','.abs($product->status-1).')">
                    <span class="label ';if($product->status!='0') { echo 'label-success'; } else { echo 'label-warning'; } echo '">';
                        if($product->status=='1') { echo 'Active';} else { echo 'Inactive';}
                    echo '</span>
                </a>
            </td>';
			
    
            
            
			echo '<td><a title="View Profile" href="'.url('admin/user/showprofile',[$product->id]).'"><i class="fa fa-desktop"></i></a>';
            echo '</tr>';
                                         
        }
    }


	public function userlist()
	{
		$users = User::whereHas('roles', function($query) {    })->where('roles_id',2)->orderBy('id','DESC')->paginate(20);	

		return view('admin.user.userlist',compact('users'));
	}
	public function updatestatus()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = User::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
        //return redirect('admin/menu');
	}
	public function inspection()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = User::find($id);
        if($model) 
        {
            $model->verify = $status;
            $model->save();
        }
        //return redirect('admin/menu');
	}
	

/*
*====================== Delete Users method ============================= 
*/
	public function deleteAll(Request $request,$id='')
    {
        $ids = $request->mul_del;
        User::whereIn('id',$ids)->delete();

        Session::flash('success_message', 'User Deleted Successfully !');
        return redirect('admin/user');
    }
/*
*====================== Add new User at Admin end ======================= 
*/
    public function useradd($id='')
    {
    	$roles = Role::all();
		return view('admin.user.useradd',compact('roles'));
    }

     public function storeuser(Request $request,$id='')
    {
                  $v = Validator::make($request->all(), [
       				     'name' => 'required|max:255',
       		         'email' => 'required|unique:users|max:255',
       		         'password' => 'required|min:8',
       		        ]);
		if ($v->fails())
    	{
      		return redirect()->back()->withInput($request->input())->withErrors($v->errors());
   		}
   		else
   		{
   			$nerd = new User;
			$nerd->name = $request['name'];
            $nerd->email = $request['email'];
            $nerd->password = md5($request['password']);
            $nerd->txtpassword = $request['password'];
            $nerd->roles_id = '2';
             
            $nerd->save();
            // redirect
            Session::flash('success_message', 'User Successfully created !');
            return redirect('admin/user');
        }
    }
/*
*====================== Edit User ====================== 
*/
    public function useredit($id='')
    {
    	//$id=$a;
		$roles = Role::where('status','1')->get();
		$states = State::where('status','1')->get();
		$cities = City::where('status','1')->get();
		
		$user = User::with('roles')->where('id',$id)->first();
		return view('admin.user.useredit',compact('user','roles'))->with('states',$states)->with('cities',$cities);
    }
    
     public function showprofile($id='')
    {
      //$id=$a;
   // $roles = Role::all();
    ///$user = User::with('roles')->with('payments')->with('payments.orders')->where('id',$id)->first();
    $user = User::with('roles')->where('id',$id)->first();
    
    $city=City::where('id',$user->city_id)->first();
    $state=State::where('id',$user->state_id)->first();
    
    //echo '<pre>';print_r($user);
    return view('admin.user.showprofile',compact('user','city','state'));
    }
    public function edituser(Request $request,$id='')
    {
        
    	$x = Validator::make($request->all(), [
       				 //'name' => 'required|max:255',
       		         'email' => 'required|max:255',
       		         //'password' => 'required|min:8',
       		        ]);
		if ($x->fails())
   		{
      		return redirect()->back()->withInput($request->input())->withErrors($x->	errors());
   		}
   		else
   		{
   		     
   		    $user = User::where('id',$id)->first();
   		    if(!empty($user))
   		    {
   		       
   		        $target='siteimages/Users/';
                $header_logo=$request->file('user_image');
                
   		      if(!empty($header_logo))
              {
                $headerImageName=$header_logo->getClientOriginalName();
                $ext1=$header_logo->getClientOriginalExtension();
                $temp1=explode(".",$headerImageName);
                $newHeaderLogo='user'.rand()."".round(microtime(true)).".".end($temp1);
                $headerTarget='siteimages/Users/'.$newHeaderLogo;
                $header_logo->move($target,$newHeaderLogo);
                $user->user_image=$headerTarget;
              }
              
                
                $user->name= ucwords(strtolower($request['name']));
                $user->email=$request['email'];
                $user->business_name=$request['business_name'];
                $user->mobile=$request['mobile'];
                $user->address=$request['address'];
                $user->latitude=$request['latitude'];
                $user->longitude=$request['longitude'];
                //$user->state_id=$request['state_id'];
                //$user->city_id=$request['city_id'];
                $user->roles_id = '2';
                $user->status=$request['status'];
                $user->verify=$request['verify'];
                $user->email_verify=$request['email_verify'];
                $user->save();
                Session::flash('success_message', 'User Updated Successfully !');
			    return back();
             }
   		    else
   		    {
   		        Session::flash('error_message', 'Somthing Went Wrong !');
   		       return back(); 
   		    }
   	    }
   	}
    public function searchuser(Request $request,$id='')
    {
    	$name=$request['name'];
    	$email=$request['email'];
    	$users = User::where('name', $name)->orWhere('email', $email)->whereHas('roles', function($query) {    })->paginate(25);
    	return view('admin.user.userlist',compact('users'));
    }
    public function forgotpassword()
    {
      //echo 'hello';
        return view("admin.user.forgotpassword");
    }
/*
*====================== Email send for Password Recovery ============ 
*/
    public function send(Request $request, $id='')
    {

       //$name = 'Krunal';
      $email=$request['email'];

       $user=User::where('email',$email)->first();
       if(!empty($user))
       {
      Mail::to($user->email)->send(new SendEmail($user->txtpassword,$user->name),function($message){

      });

      Session::flash('success_message', 'Password has been sent on your Registered email !');
       
      return redirect('admin');
      }

      Session::flash('success_message', 'Invalide Email!');
      return redirect('admin/forgotpass');

     }

   

/*
*====================== All Admin Methods End ============================= 
*/



/*
*====================== All Frontend User Methods ====================== 
*/
    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
               'email' => 'required|max:255',
               'password'=>'required',
                  ]);
      if ($v->fails())
      {
        return redirect()->back()->withInput($request->input())->withErrors($v->errors());
      }
      else
      {
      $email = $request->input('email');
      $pass = md5($request->input('password'));
      $model = User::with('addresses')->with('roles')->where('email',$email)->where('password',$pass)->where('status','1')->first();
      
      //echo '<pre>';print_r($model);
      //die;
      if (!$model == null)
      { 
         if($model->email_verify=='1')
         {
        session(['userid' => $model->id]);
        session(['username' => $model->name]);
        session(['useremail' => $model->email]);
        session(['role' => $model->roles->name]);// Or
        session(['roleid'=>$model->roles->id]);
        session(['profile_image'=>$model->user_image]);
       // Session::put('business_status',$model->upgraded_business);
       if($model->verify=='1')
       {
        Session::put('verify_status',true);
       }
       else 
       {
        Session::put('verify_status',false);
       }
        
      //  $sp_business=SpecializeBusiness::where('user_id',$model->id)->where('status','1')->first();
      //  $payment=Payment::where('payer_email',Session::get('useremail'))->first();

        if($model->upgraded_business=='1')
        {
          Session::put('business_status',true);
        }
        else
        {
          Session::put('business_status',false); 
        }
        
        $subscription=Subscription::where('user_id',$model->id)->first();
        if(!empty($subscription))
        {
          Session::put('subscription_status',true);
        }
        else
        {
         Session::put('subscription_status',false); 
        }
        
        
        if($model->roles->name =='user')
        {
          if(Session::has('login_type'))//Session::has('business_slug'))
          {
            $login=Session::get('login_type');

             if($login=='review')
            {
              return redirect('users/write-a-review');  
            }
            else if($login=='quote')
            {
              return redirect('users/get-a-quote');   
            }
          }
         return redirect('users/profile');
        }
        else if($model->roles->name=='business')
        {
           if(Session::has('login_type'))//Session::has('business_slug'))
          {
            $login=Session::get('login_type');

             if($login=='review')
            {
              return redirect('business/write-a-review');  
            }
            else if($login=='quote')
            {
              return redirect('business/get-a-quote');   
            }
          }
            return redirect('business/profile');
          //Session::flash('message', "Access denied!");
        }
        else
        {
            Session::flash('error_message', "Access denied!");
        }
        //echo '<pre>';print_r($model->roles->name);
        }
        else
        {
          Session::flash('error_message', 'Invalid Email or Password!');
      return redirect('/login');  
        }
      }      
      else
      {
      Session::flash('error_message', 'Invalid Email or Password!');
      return redirect('/login');
      }
      
      return redirect('/login');
    }
  }
/*
*====================== Sign up ====================== 
*/
     public function signup(Request $request)
     {
          $v = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            
            'agree_terms' => 'required',
            'mobile' => 'required',
            'mobile' => 'required|size:10',//regex:/(01)[0-9]{9}/',
            'address'=>'required',
            'password' => 'required|min:8',
             ],
             [
      
      'first_name.required'=>'First name required',
      'last_name.required'=>'Last name required',
      'email.required'=>'Email required',
      'mobile.required'=>'Mobile number required',
      'mobile.size'=>'Mobile number should be 10 digits',
      'password.required'=>'Password required',
      'password.min'=>'Password must be atleast 8 digits long',
      'confirm_password.required'=>'Confirm password required',
      'address.required'=>'Address required',
      'agree_terms.required'=>'Please accept terms & conditions',
      
                    ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        else
        {
             
        $email=$request['email'];
            
        $new_token=$this->generate_token();
        $user=new User;
        
       $user=new User;
      // $new_token=$this->generate_token();
       //echo $new_token;
      // die;

       $user->first_name=ucwords(strtolower($request['first_name']));//$request['first_name'];
       $user->last_name=ucwords(strtolower($request['last_name']));
                          //$request['last_name'];
       $user->name= ucwords(strtolower($request['first_name'])).' '.ucwords(strtolower($request['last_name']));
       $user->email=$request['email'];
       $user->password=md5($request['password']);
       $user->txtpassword=$request['password'];
       $user->mobile=$request['mobile'];
       $user->address=$request['address'];
       $user->latitude=$request['latitude'];
       $user->longitude=$request['longitude'];
       $user->state_id=$request['state_id'];
       $user->city_id=$request['city_id'];
       $user->agree_terms='1';
       $user->verify_token=$new_token;    
      // $user->verify_token=$new_token;//$request['_token'];
       $user->status='1';
       $user->save();

       $user_address=new UserAddress;
       $user_address->user_id=$user->id;
       $user_address->address=$request['address'];
       $user_address->longitude=$request['longitude'];
       $user_address->latitude=$request['latitude'];
       $user->state_id=$request['state_id'];
       $user->city_id=$request['city_id'];
       $user_address->primary_status='1';
       $user_address->status='1';
       $user_address->save();

     return  $this->send_verify_mail($new_token,$email,$user->name);
      
      //Session::flash('success_message', 'Registered Successfully!');
      //return redirect('/login');
        }
     }
  public function my_booking()
  {
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
    return view('users.my_booking')
            ->with('blogs',$blogs);
  }
  public function my_booking_details()
  {
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
    return view('users.my_booking_details')
            ->with('blogs',$blogs);
  }
  public function review_rating()
  {

   $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
   
   $myreviews=Review::with('senders')->where('user_id',Session::get('userid'))->orderBy('id','DESC')->get();
   
    //Here Business = User with business profile

   //echo '<pre>';print_r($myreviews);
  // die;
    return view('users.review_and_rating')
            ->with('blogs',$blogs)
            ->with('myreviews',$myreviews); 
  }
  public function write_a_review()
  {
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
    /*if(Session::has('business_slug'))
    {

    $business=SpecializeBusiness::with('users')->where('slug',Session::get('business_slug'))->first();

    //echo '<pre>';print_r($business->users->id);
    //   die;
    return view('users.write_a_review')
           ->with('business',$business->users->id)
           ->with('blogs',$blogs);
    }
    return back();
    */
    if(!empty($_GET['rec']))
    {
        $user=User::where('id',base64_decode($_GET['rec']))->first(['id as user_id','name','email']);   
        return view('users.write_a_review')
            ->with('blogs',$blogs)
            ->with('user',$user)
            ->with('booking_id',$_GET['booking']);
    }
    else
    {
       Session::flash('error_message', ' Verification Email has been sent Please Verify Your Email id !');
       return redirect('users/my-booking');
    }
    
  }

  public function store_review(Request $request)
  {     
      $nreview=new Review;
      $nreview->user_id=base64_decode($request['receiver_id']);
      $nreview->sender_id=Session::get('userid');
      $nreview->review_heading=$request['review_heading'];
      $nreview->slug=str_slug($request['review_heading']);
      $nreview->content=$request['content'];
      $nreview->rating=$request['rating'];
      $nreview->booking_id=base64_decode($request['booking']);
    //  $nreview->user_send_receive='0';
    //  $nreview->business_send_receive='1';
      $nreview->save();

      Session::forget('business_slug');
      Session::forget('login_type');
     // Session::flash('message', 'Invalid Password!');
      Session::flash('success_message','Thank you for Rating');
      return redirect('users');

  }
  public function get_a_quote()
  {
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
    if(Session::has('business_slug'))
    {

    $business=SpecializeBusiness::with('users')->where('slug',Session::get('business_slug'))->first();

    //echo '<pre>';print_r($business->users->id);
    //   die;
    return view('users.get_a_quote')
           ->with('business',$business)
           ->with('blogs',$blogs);
    }
    return back();
  }
  public function store_quote(Request $request)
  {
    $new_quote=new Quote;
    $new_quote->business_id=base64_decode($request['business_user_id']);
    $new_quote->user_id=Session::get('userid');
    $new_quote->quote_title=$request['quote_title'];
    $new_quote->message=$request['message'];
    $new_quote->status='1';
    $new_quote->save();

    $business=User::where('id',base64_decode($request['business_user_id']))->first();
    $admin_mail=Session::get('siteInfo')->site_email1;//SiteSetting::where('id','1')->first();
    $user=User::where('id',Session::get('userid'))->first();

    $title=$request['quote_title'];
    

    $msg=$request['message'];


    //$message = preg_replace("/&#?[a-z0-9]{2,8};/i","",$request['message']);
    Mail::to('sharvan@webmobriltechnologies.com')->send(new SendQuote($title,$msg,$user->name,$user->email,$user->mobile,$business->name),function($message){
       
        });
    Session::forget('business_slug');
    Session::forget('login_type');
    
    Session::flash('success_message','Quote sent..');
    return redirect('users/profile');
  }

  public function my_booking_user()
  {
          
    //$pending_bookings=Booking::where('user_id',Session::get('userid'))->where('status','0')->orderBy('id','DESC')->get();     
    $bookings=DB::select('select b.id as booking_id,b.location,b.status,b.created_at, u.id as provider_id, u.name as provider_name, u.email, u.mobile, u.address as provider_address,u.user_image as image, (select avg(rating) from reviews where reviews.user_id=u.id) as rating from  bookings b, users u where b.business_id=u.id and b.user_id=? order by b.id desc',[Session::get('userid')]);
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
    return view('users.my_booking_user')
            ->with('blogs',$blogs)
            ->with('bookings',$bookings)
            //->with('pending_bookings',$pending_bookings)
            ;
          

  }
  public function booking_details()
  {
    $booking_id=base64_decode($_GET['booking']);
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
    
     
    /* $booking_details=Booking::with('business')
                              ->with('business.reviews')
                              //->with('specialize_business.users')
                              ->with('service_booking.services')   
                              ->where('id',$booking_id)
                              ->first();
        */
        
    $booking_details=Booking::with('business')
                        ->with('service_booking')
                        ->with('service_booking.services')
                        ->where('id',$booking_id)
                        ->first();
    //echo '<pre>';print_r($booking_details);
    $rating=Review::where('user_id',$booking_details->business_id)
                     ->where('sender_id',Session::get('userid'))
                     ->where('booking_id',$booking_id)
                   //  ->where('business_send_receive','0')
                     ->avg('rating');        
 
    return view('users.booking_details_user')
            ->with('blogs',$blogs)
            ->with('booking_details',$booking_details)
            ->with('rating',$rating);
  }
 
  public function generate_token()
  {
    $text="9568472130";     //80 characters

    return $text=substr(str_shuffle($text),0,6);

  }
  public function send_verify_mail($token='',$email='',$name='')
  {
      //$user=User::where('email',$email)->first();

      if(!empty($email))
      {
      Mail::to($email)->send(new EmailVerify($token,$email,$name),function($message){

      });

      Session::flash('success_message', ' Verification Email has been sent Please Verify Your Email id !');
      
     // $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
      //Session::put('verify_email',$email);
      //return redirect('verify-otp',base64_encode($email));//return redirect('verify-otp');
      return \Redirect::route('verify-otp', base64_encode($email));//->with('message', 'State saved correctly!!!');
              //->with('blogs',$blogs);
              //->with('email',$email);
      }
     // return $email;
       return back();

       

     
  }
  public function become_an_provider()
  {
  
    $user=User::where('id',Session::get('userid'))->first();
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
        $states=State::where('status','1')->orderBy('name','ASC')->get();
        $cities=City::where('state_id',$user->state_id)
                      ->where('status','1')->get();   
        $tc_data=Page::where('slug','terms-and-agreement-provider')->where('status','1')->first();
    
     return view('users.become_an_provider')
                ->with('blogs',$blogs)
                ->with('states',$states)
                ->with('cities',$cities)
                ->with('userdata',$user)
                ->with('tc_data',$tc_data);
  }
  public function create_provider_profile(Request $request)
  {
      $current=Carbon::today();
    
    $status=false;
    $target='siteimages/Business/';
    $userdata=User::where('id',Session('userid'))->first();
    if(!empty($userdata))
      {
        $v = Validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                   // 'email' => 'required|max:255',
                    'mobile' => 'required',
                    'mobile' => 'required|size:10',
                    //'business_name'=>'required',
                    'address'=>'required',
                    //'state_id'=>'required',
                    //'city_id'=>'required',
                    'agree_terms'=>'required',
                  ],
    [
    'first_name.required'=>'Please Enter Your First Name',
    'mobile.required'=>'Please Enter Mobile Number',
    'mobile.required|size:10'=>'Mobile Number Should Be 10 Digits',
    //'business_name.required'=>'Please Enter your Business Name',
    'address.required'=>'Please Enter Address',
    //'state_id.required'=>'Please Select State',
    //'city_id.required'=>'Please Select City',
    'agree_terms.required'=>'Please Accept Terms and Agreements',
      ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        else
        {
            
          $documents=UserDocument::where('user_id',$userdata->id)->first();
          if(empty($documents))
          {
            $documents=new UserDocument;
          }
          
//--------------------Driver's licence------------------
      $dl_image=$request->file('dl_image');
      if(!empty($dl_image))
      {
        $dlImageName=$dl_image->getClientOriginalName();
        $ext1=$dl_image->getClientOriginalExtension();
        $temp1=explode(".",$dlImageName);
        $newdl='bd'.rand()."".round(microtime(true)).".".end($temp1);
        $dlTarget='siteimages/Business/'.$newdl;
        $dl_image->move($target,$newdl);
        $documents->dl_image=$dlTarget;

        $documents->dl_doc_no=$request['dl_doc_no'];
        $documents->dl_exp_date=$request['dl_exp_date'];
        if(strtotime($request['dl_exp_date'])>strtotime($current))
        {
            $documents->dl_status='1';
        }
        else
        {
            $documents->dl_status='0';
        }
            
        

      }
      
//---------- -Social Security's certificate---------------    
      $ssc_image=$request->file('ssc_image');
      if(!empty($ssc_image))
      {

        $sscImageName=$ssc_image->getClientOriginalName();
        $ext1=$ssc_image->getClientOriginalExtension();
        $temp1=explode(".",$sscImageName);
        $newssc='bd'.rand()."".round(microtime(true)).".".end($temp1);
        $sscTarget='siteimages/Business/'.$newssc;
        $ssc_image->move($target,$newssc);
        $documents->ssc_image=$sscTarget;

        $documents->ssc_doc_no=$request['ssc_doc_no'];
        $documents->ssc_exp_date=$request['ssc_exp_date'];
        
        if(strtotime($request['ssc_exp_date'])>strtotime($current))
        {
            $documents->ssc_status='1';
        }
        else
        {
            $documents->ssc_status='0';
        }

          
      }
      
//--------------------Insurance------------------    
      $insurance_image=$request->file('insurance_image');
      if(!empty($insurance_image))
      {
        $insuranceImageName=$insurance_image->getClientOriginalName();
        $ext1=$insurance_image->getClientOriginalExtension();
        $temp1=explode(".",$insuranceImageName);
        $newinsurance='bd'.rand()."".round(microtime(true)).".".end($temp1);
        $insuranceTarget='siteimages/Business/'.$newinsurance;
        $insurance_image->move($target,$newinsurance);
        $documents->insurance_image=$insuranceTarget;

        $documents->insurance_doc_no=$request['insurance_doc_no'];
        $documents->insurance_exp_date=$request['insurance_exp_date'];
        
        if(strtotime($request['insurance_exp_date'])>strtotime($current))
        {
            $documents->insurance_status='1';
        }
        else
        {
            $documents->insurance_status='0';
        }
        
        
        
      }
//--------------------Certification------------------    
   /*   $certification_image=$request->file('certification_image');
      if(!empty($certification_image))
      {
        $certificationImageName=$certification_image->getClientOriginalName();
        $ext1=$certification_image->getClientOriginalExtension();
        $temp1=explode(".",$certificationImageName);
        $newcertification='bd'.rand()."".round(microtime(true)).".".end($temp1);
        $certificationTarget='siteimages/Business/'.$newcertification;
        $certification_image->move($target,$newcertification);
        $documents->certification_image=$certificationTarget;

        $documents->certification_doc_no=$request['certification_doc_no'];
        $documents->certification_exp_date=$request['certification_exp_date'];
        
        if(strtotime($request['certification_exp_date'])>strtotime($current))
        {
            $documents->certification_status='1';
        }
        else
        {
            $documents->certification_status='0';
        }
        
         
        
      }
      
      */
//-------------Corporate vehicle document------------------    
 /*     $cvd_image=$request->file('cvd_image');
      if(!empty($cvd_image))
      {
        $cvdImageName=$cvd_image->getClientOriginalName();
        $ext1=$cvd_image->getClientOriginalExtension();
        $temp1=explode(".",$cvdImageName);
        $newcvd='bd'.rand()."".round(microtime(true)).".".end($temp1);
        $cvdTarget='siteimages/Business/'.$newcvd;
        $cvd_image->move($target,$newcvd);
        $documents->cvd_image=$cvdTarget;

        $documents->cvd_doc_no=$request['cvd_doc_no'];
        $documents->cvd_exp_date=$request['cvd_exp_date'];
    
        if(strtotime($request['cvd_exp_date'])>strtotime($current))
        {
            $documents->cvd_status='1';
        }
        else
        {
            $documents->cvd_status='0';
        }
        
        
      }
      */
//--------------------Police Clearance Certificate (PCC)------------------
      $pcc_image=$request->file('pcc_image');
      if(!empty($pcc_image))
      {
        $pccImageName=$pcc_image->getClientOriginalName();
        $ext1=$pcc_image->getClientOriginalExtension();
        $temp1=explode(".",$pccImageName);
        $newdl='bd'.rand()."".round(microtime(true)).".".end($temp1);
        $dlTarget='siteimages/Business/'.$newdl;
        $pcc_image->move($target,$newdl);
        $documents->pcc_image=$dlTarget;

        $documents->pcc_doc_no=$request['pcc_doc_no'];
        $documents->pcc_issue_date=$request['pcc_issue_date'];
        if(strtotime($request['pcc_issue_date'])<strtotime($current))
        {
            $documents->pcc_status='1';
        }
        else
        {
            $documents->pcc_status='0';
        }
            
         
      }

      $documents->user_id=Session::get('userid');
      $documents->save();
//--------------------End of Documents -------------------------------      
      
       $userdata->first_name=ucwords(strtolower($request['first_name']));//$request['first_name'];
       $userdata->last_name=ucwords(strtolower($request['last_name']));
                          //$request['last_name'];
       $userdata->name= ucwords(strtolower($request['first_name'])).' '.ucwords(strtolower($request['last_name']));
       $userdata->business_name=ucwords(strtolower($request['business_name']));
        //$userdata->email=$request['email'];
        $userdata->mobile=$request['mobile'];
        $userdata->address=$request['address'];
        $userdata->latitude=$request['latitude'];
        $userdata->longitude=$request['longitude'];
        $userdata->state_id=$request['state_id'];
        $userdata->city_id=$request['city_id'];
        $userdata->verify='1';
        $userdata->roles_id='5';
        $userdata->upgraded_business='1';
        //$userdata->agree_terms='1';
        $userdata->save();
        
        $property=UserAddress::where('user_id',Session::get('userid'))->where('primary_status','1')->first();
            if(empty($property))
            {
                $property=new UserAddress;
            }
                $property->address=$request['address'];
                $property->latitude=$request['latitude'];
                $property->longitude=$request['longitude'];
                $property->city_id=$request['city_id'];
                $property->state_id=$request['state_id'];
                $property->primary_status=1;
                $property->user_id=Session::get('userid');
                $property->save();
        
        
//===========  Send for Stripe Account Creation if User is Business ============
            /*    if($userdata->roles_id==5)
                {
                    $create_stripe_account=new StripeMoneyControlller;
                    
                    $create_stripe_account->create_account($userdata);
                }
                */
//==============================================================================

        Session::put('verify_status',false);

        $model=User::where('id',Session::get('userid'))->first();

        session(['role' => $model->roles->name]);// Or
        session(['roleid'=>$model->roles->id]);
        //session(['profile_image'=>$model->user_image]);
        
      
       }
        Session::flash('success_message', 'Service Provider Profile Created Successfully!');
        return redirect('business/profile');   
      }
      
        Session::flash('error_message', 'Something Went Wrong!');
        return back();   
      
    }
    public function sended_quotes()
    {
        $sended_quotes=Quote::with('receivers')->where('user_id',Session::get('userid'))->get();
         $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
        // return $all_received_quotes;
       //  die;
        return view('users.sended_quote_user')
                    ->with('sended_quotes',$sended_quotes)
                    ->with('blogs',$blogs);
    }
    
    public function quote_details_user()
  {
     
      $quote_id=$_GET['quote_id'];
      $quote_details=Quote::with('receivers')->where('id',$quote_id)->where('user_id',Session::get('userid'))
                        ->first();

      echo '<div class="col-md-12 col-sm-12">
              <div class="row info">
                <div class="col-md-12 col-sm-12">
                  <!--     <h4><b>To</b></h4>  -->
                  <h4><b id="name">'.$quote_details->receivers->name.'</b></h4>
                  
                </div>
              </div>
              <hr>
              <div class="row info">
                <div class="col-md-12 col-sm-12">
                  <!--     <h4><b>Title</b></h4>  -->
                  <h4><b>'.$quote_details->quote_title.'</b></h4>
                   
                </div>
              </div>
              <hr>
              </div>
              <div class="row info">
                <div class="col-md-12 col-sm-12">
                  <h4><b>Message</b></h4>
                  <p>'.$quote_details->message.'</p>
                </div>
              </div>
              <hr>
               
            
            </div>';

         
    }
  public function add_address_user()
  {
    //$user=User::where('id',Session::get('userid'))->first();

    $address=UserAddress::with('users')->with('city')->with('state')->where('user_id',Session::get('userid'))->where('status','1')->orderBy('primary_status','DESC')->get();
    $cities=City::where('status','1')->orderBy('name','ASC')->get();
    $states=State::where('status','1')->orderBy('name','ASC')->get();
    $blogs=Blog::where('status','1')->orderBy('updated_at','Desc')->paginate(3);
    return view('users.add_address_user')
            ->with('cities',$cities)
            ->with('states',$states)
           // ->with('user',$user)
            ->with('address',$address)
            ->with('blogs',$blogs);
   }
  
  function save_address_user(Request $request)
  {
      $new_address=new UserAddress;
     $new_address->address=$request['address'];
     $new_address->longitude=$request['longitude'];
     $new_address->latitude=$request['latitude'];
     $new_address->city_id=$request['city_id'];
     $new_address->state_id=$request['state_id'];
     $new_address->user_id=Session::get('userid');
     $new_address->save();
    
    Session::flash('success_message', 'Address added!');
    return redirect('users/add-address');  
     
  }
  public function address_details()
  {
       $address_id=$_GET['address_id'];
       $address_details=UserAddress::with('city')->with('state')->where('id',$address_id)->where('user_id',Session::get('userid'))
                        ->first();
          
        $states=State::where('status','1')->get();
        $cities=City::where('state_id',$address_details->state_id)->where('status','1')->get();
        
        echo $address_details->id.'~'.$address_details->address.'~'.$address_details->longitude.'~'.$address_details->latitude.'~'.$address_details->state_id.'~'.$address_details->city_id.'~';
        
        foreach($states as $state)
        {
         echo '<option value="'.$state->id.'"';
            if($state->id==$address_details->state_id) 
              { 
                  echo 'selected="true"'; 
                  
              } 
              echo '>'.$state->name.'</option>';
        }
        echo '~';
        foreach($cities as $city)
        {
         echo '<option value="'.$city->id.'"';
            if($city->id==$address_details->city_id) 
              { 
                  echo 'selected="true"'; 
                  
              } 
              echo '>'.$city->name.'</option>';
        }
        //.','.$states;  
                        
    
        //$states=State::where('status','1')->get();
        //$cities=City::where('status','1')->get();
     
     


 
//echo '<script type="text/javascript">alert("hello!");</script>';
 
/*
 echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
        echo '<script type="text/javascript">';
        
        echo '
            $(document).ready(function(){';

    echo    '$("#state_idd").on("change",function(){
         var stateID = $(this).val();
        if(stateID){
          $.ajax({
            type:"GET",
            url:"../cityData",
            data:"state_id="+stateID,
            success:function(html){

        $("#city_idd").html(html);

        }
        }); 
        }else{
          $("#city_idd").html("<option value="">Select State first</option>");

        }
      });   
 }); 
 
 });
 
 </script>
 ';
 */
     
    }
    public function update_address_user(Request $request)
    {
        $address=UserAddress::where('id',$request['address_id_up'])->where('user_id',Session::get('userid'))->first();
        
        
        if(!empty($address))
        {
        $address->address=$request['address1'];
        $address->latitude=$request['latitude1'];
        $address->longitude=$request['longitude1'];
       // $address->state_id=$request['state_idd'];
        //$address->city_id=$request['city_idd'];
        $address->save();
        
        if($address->primary_status==1)
        {
            $user=User::where('id',Session::get('userid'))->first();
            $user->address=$request['address1'];
            $user->latitude=$request['latitude1'];
            $user->longitude=$request['longitude1'];
            $user->save();
        }
        Session::flash('success_message', 'Address Updated!');
        return redirect('users/add-address'); 
        }
        else
        {
         Session::flash('error_message', 'Something Went Wrong!');
            return redirect('users/add-address'); 
        }
       //echo $request['address_id'];
    }
    public function remove_address_user(Request $request)
    {
        //remove-address
        
         $property=UserAddress::where('id',$request['address_id_remove'])->where('user_id',Session::get('userid'))->first();
        if($property->primary_status==1)
        {
            Session::flash('error_message', "Can't Remove Primary Address!");
            return redirect('users/add-address');    
        }
        $property->delete();
        
        Session::flash('success_message', 'Address Removed!');
        return redirect('users/add-address');
        
        
        
       /* 
        UserAddress::where('id',$request['address_id_remove'])->where('user_id',Session::get('userid'))->delete();
        Session::flash('success_message', 'Address Removed!');
        return redirect('users/add-address');
        */
        
    }
    
/*================= Document Status ===================*/
    public function update_dl_status()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        
        $docs = UserDocument::where('user_id',$id)->first();
        if($docs) 
        {
            $docs->dl_status = $status;
            $docs->save();
        } 
        $this->verify_status($docs,$id); 
    }
    public function update_ssc_status()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $docs = UserDocument::where('user_id',$id)->first();
        if($docs) 
        {
            $docs->ssc_status = $status;
            $docs->save();
        }
        $this->verify_status($docs,$id); 
    }
    public function update_insurance_status()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $docs = UserDocument::where('user_id',$id)->first();
        if($docs) 
        {
            $docs->insurance_status = $status;
            $docs->save();
        } 
        $this->verify_status($docs,$id); 
    }
    public function update_pcc_status()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $docs = UserDocument::where('user_id',$id)->first();
        if($docs) 
        {
            $docs->pcc_status = $status;
            $docs->save();
        }
        $this->verify_status($docs,$id);       
        
        
    }
    public function verify_status($docs,$id)
    {
        if($docs->dl_status==0 || $docs->ssc_status==0 || $docs->insurance_status==0 || $docs->pcc_status==0 )
        {
            $user=User::where('id',$id)->first();
            $user->verify=0;
            
        }
        else
        {
            $user=User::where('id',$id)->first();
            $user->verify=1;
            
        }
        $user->save();
    }
    public function active_users()
    {
        $users = User::with('roles')->where('status','1')->paginate(10);	
        return view('admin.user.userlist',compact('users')); 
    }
    public function email_verification_pending()
    {
        
        $users = User::with('roles')->where('email_verify','0')->paginate(10);	
        return view('admin.user.userlist',compact('users')); 
    }
//==================== Make Primary Address ==============================
    public function make_primary()
    {
        
        
        UserAddress::where('user_id',Session::get('userid'))->update(array('primary_status'=>'0'));
        
        $property=UserAddress::where('id',$_GET['id'])->where('user_id',Session::get('userid'))->first();
        if(!empty($property))
        {
            $property->primary_status=1;
            $property->save();
            
            $user=User::where('id',Session::get('userid'))->first();
            $user->address=$property->address;
            $user->latitude=$property->latitude;
            $user->longitude=$property->longitude;
            $user->city_id=$property->city_id;
            $user->state_id=$property->state_id;
            $user->save();
        }
        else
        {
          return 'Somthing went Wrong';  
        }
    }

}
 
/*
*======================Rough Code=================================
*/


/*
====================== 1 ==============================>

 /* public static function test(Request $request)
  {
    //echo 'hello';
    //$request=new Request;
    if($request->isMethod('post'))
    {
      return $this->login($request);
      //return view('propertymd.login_as_user');
    }
    else if($request->isMethod('get'))
    {
      return view('propertymd.login_as_user');
      //return $this->login();
    }
  }
  */




 
        
    