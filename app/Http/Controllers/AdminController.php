<?php

namespace App\Http\Controllers;
use App\User;
use App\AdminMenu;
use App\Role;
use App\UserPermission;
use Validator;
use App\SiteSetting;
use App\Company;
use App\Category;
use App\FarmVisits;
use Illuminate\Http\Request;
use Session;
use DB;
class AdminController extends Controller
{
    /*
    |*********************************************************
    |                   GET Methods
    |*********************************************************
    */
    public function getMethods($method1='',$method2='',$id='')
    {   
        $this->siteInfo();
        if(Session::has('bu_user_info'))
        {
           AdminMenusController::adminMenus(Session::get('bu_user_info')->roles_id);
        }

        if(!empty($method1))
        {
            if(!empty($id))
            {
                $status=$this->verify();
                if($status==true)
                {
                    //return $this->$method2($id); 
                    //return $this->getRequest($method2,$id);
                    return $this->getRequest($method1,$method2,$id);
                    
                }
                else
                {
                    return redirect('admin');
                }
            }
            else
            {

                $status=$this->verify();
                
                if($status==true)
                {
                    //return $this->$method1($id); 
                   // return $this->getRequest($method1,$id);
                   return $this->getRequest($method1,$method2,$id);
                }
                else
                {
                    return redirect('admin');
                }
            }


        }
        else
        {   
            $status=$this->verify();
            if($status==true)
            {
                return redirect('/admin/dashboard');
            }
            else
            {
                return view('admin.login');
            }
        }
    }
    /*
    |*********************************************************
    |                   All GET Methods
    |*********************************************************
    */
    public function getRequest($method1='',$method='',$data='')
    {   
        
        $flag= $this->myMiddleWare($method1);
        $meth='';
        if(!empty($data))
        {
            $meth=$method;
        }
        else
        {
            $meth=$method1;
        }
        if($flag=="true")
        {
            switch($meth)
            {
                case 'dashboard':
                    return $this->dashboard();
                break;
            
                            
     /*
    |*********************************************************
    |                   Product Subscriptions
    |*********************************************************
    */            
                case 'product-subscriptions':
                    return $this->product_subscriptions();
                break;
                /*case 'edit-certificate':
                    return $this->certificateedit($data);
                break;
                
                case 'add-certificate':
                    return $this->certificateadd();
                break;*/
                            
   
    /*
    |*********************************************************
    |                   Packages
    |*********************************************************
    */            
                case 'packages':
                    return $this->packages();
                break;
                case 'edit-package':
                    return $this->edit_package($data);
                break;
                case 'updatepackagestatus':
                    return $this->updatepackagestatus();
                break;
                case 'deleteallpackages':
                    return $this->deleteallpackages();
                break;
                case 'add-package':
                    return $this->add_package();
                break;   
              
              
    /*
    |*********************************************************
    |                   Signup as providers
    |*********************************************************
    */            
                case 'signup-as-provider':
                    return $this->signup_as_provider();
                break;
                case 'edit-package':
                    return $this->edit_package($data);
                break;
                case 'updatepackagestatus':
                    return $this->updatepackagestatus();
                break;
                case 'deleteallpackages':
                    return $this->deleteallpackages();
                break;
                case 'add-package':
                    return $this->add_package();
                break;   
                        
   
    /*
    |*********************************************************
    |                   Country
    |*********************************************************
    */            
                case 'country':
                    return $this->country();
                break;
                case 'countryedit':
                    return $this->countryedit($data);
                break;
                case 'updatecountrystatus':
                    return $this->updatecountrystatus();
                break;
                case 'deleteallcountry':
                    return $this->deleteallcountry();
                break;
                case 'countryadd':
                    return $this->countryadd();
                break;
                
    /*
    |*********************************************************
    |                   Delivery charge
    |*********************************************************
    */            
                case 'delivery-charge':
                    return $this->delivery_charge();
                break;
                case 'edit-charge':
                    return $this->edit_charge($data);
                break;
                case 'updatedeliverycstatus':
                    return $this->updatedeliverycstatus();
                break;
                case 'deletealldeliveryc':
                    return $this->deletealldeliveryc();
                break;
                case 'add-new-charge':
                    return $this->add_new_charge();
                break;
                
    /*
    |*********************************************************
    |                   Order
    |*********************************************************
    */            
                case 'orders':
                    return $this->orders();
                break;
                case 'view-order':
                    return $this->view_order($data);
                break;            
                
    /*
    |*********************************************************
    |                   Units
    |*********************************************************
    */            
                case 'units':
                    return $this->unit();
                break;
                case 'edit-unit':
                    return $this->unitedit($data);
                break;
                case 'updateunitstatus':
                    return $this->updateunitstatus();
                break;
                case 'deleteallcountry':
                    return $this->deleteallcountry();
                break;
                case 'add-unit':
                    return $this->addunit();
                break;
                
      
    /*
    |*********************************************************
    |                   Offer banners
    |*********************************************************
    */            
                case 'banners':
                    return $this->banners();
                break;
                case 'edit-banner':
                    return $this->edit_banner($data);
                break;
                case 'updatebannerstatus':
                    return $this->updatebannersstatus();
                break;
                
                case 'add-banner':
                    return $this->addbanner();
                break;
                
    /*
    |*********************************************************
    |                   Reports
    |*********************************************************
    */            
                case 'reports':
                    return $this->reports();
                break;
                case 'edit-report':
                    return $this->editreport($data);
                break;
                case 'updatereportstatus':
                    return $this->updatereportstatus();
                break;
                
                case 'add-report':
                    return $this->addreport();
                break;
                
    /*
    |*********************************************************
    |                   Transactions
    |*********************************************************
    */            
                case 'transactions':
                    return $this->transactions();
                break;
                
    
    /*
    |*********************************************************
    |                   State
    |*********************************************************
    */
                case 'state':
                    return $this->state();
                break;
                case 'stateedit':
                    return $this->stateedit($data);
                break;
                case 'updatestatestatus':
                    return $this->updatestatestatus();
                break;
                case 'deleteallstate':
                    return $this->deleteallstate();
                break;
                case 'stateadd':
                    return $this->stateadd();
                break;
    /*
    |*********************************************************
    |                   City
    |*********************************************************
    */            
                case 'city':
                    return $this->city();
                break;
                case 'edit-city':
                    return $this->cityedit($data);
                break;
                case 'updatecitystatus':
                    return $this->updatecitystatus();
                break;
                case 'deleteallcity':
                    return $this->deleteallcity();
                break;
                case 'add-city':
                    return $this->cityadd();
                break;
    /*
    |*********************************************************
    |                 BackEnd  Menu
    |*********************************************************
    */          case 'menu':
                    return $this->menu();
                break;
                case 'menuedit':
                    return $this->menuedit($data);
                break;
                case 'menuadd':
                    return $this->menuadd();
                break;
                case 'updatemenustatus':
                    return $this->updatemenustatus();
                break;
                case 'deleteallmenu':
                    return $this->deleteallmenu();
                break;


    /*
    |*********************************************************
    |                   Permission
    |*********************************************************
    */    
                case 'permission':
                    return $this->permission();
                break;
                case 'permissionData':
                    return $this->permissionData();
                break;
                
    /*
    |*********************************************************
    |                 Users
    |*********************************************************
    */          case 'user':
                    return $this->user();
                break;
                case 'useredit':
                    return $this->useredit($data);
                break;
                case 'useradd':
                    return $this->useradd($data);
                break;
                case 'profile':
                    return $this->profile($data);
                break;
                case 'showprofile':
                    return $this->showprofile($data);
                break;
                case 'updateuserstatus':
                    return $this->updateuserstatus();
                break;
                case 'inspection':
                    return $this->inspection();
                break;
                case 'deletealluser':
                    return $this->deletealluser();
                break;
    /*
    |*********************************************************
    |                 Service providers
    |*********************************************************
    */          case 'service-provider':
                    return $this->serviceProvidersList();
                break;
                case 'view-profile':
                    return $this->providerProfile($data);
                break;
                case 'updateprovidersstatus':
                    return $this->updateprovidersstatus();
                break;
                case 'updateInspection':
                    return $this->updateInspection();
                break;
                case 'deleteallprovider':
                    return $this->deleteallprovider();
                break;
                
    /*
    |*********************************************************
    |                 Drivers
    |*********************************************************
    */          case 'drivers':
                    return $this->driverList();
                break;
                case 'driver-profile':
                    return $this->driverProfile($data);
                break;
                case 'updatedriversstatus':
                    return $this->updatedriversstatus();
                break;
                case 'updateDriverInspection':
                    return $this->updateDriverInspection();
                break;
                case 'deletealldriver':
                    return $this->deletealldriver();
                break;            
                
    /*
    |*********************************************************
    |                 Roles
    |*********************************************************
    */          case 'role':
                    return $this->role();
                break;
                case 'roleedit':
                    return $this->roleedit($data);
                break;
                case 'roleadd':
                    return $this->roleadd();
                break;
                case 'updaterolestatus':
                    return $this->updaterolestatus();
                break;
                case 'deleteallroles':
                    return $this->deleteallroles();
                break;
    /*
    |*********************************************************
    |                 Pages
    |*********************************************************
    */          case 'pages':
                    return $this->pages();
                break;
                case 'pageedit':
                    return $this->pageedit($data);
                break;
                case 'pageadd':
                    return $this->pageadd();
                break;
                case 'updatepagestatus':
                    return $this->updatepagestatus();
                break;
                case 'deleteallpages':
                    return $this->deleteallpages();
                break;
    /*
    |*********************************************************
    |                 Front End Menus
    |*********************************************************
    */          case 'frontmenu':
                    return $this->frontmenu();
                break;
                case 'frontmenuedit':
                    return $this->frontmenuedit($data);
                break;
                case 'updatefrontmenustatus':
                    return $this->updatefrontmenustatus();
                break;
    /*
    |*********************************************************
    |                 Site Settings
    |*********************************************************
    */          case 'sitesetting':
                    return $this->sitesetting();
                break;
    
   
                
     /*
    |*********************************************************
    |                 Product Category
    |*********************************************************
    */          case 'product-category':
                    return $this->product_category();
                break;
                case 'edit-product-category':
                    return $this->edit_product_category($data);
                break;
                case 'add-product-category':
                    return $this->add_product_category();
                break;
                
    /*
    |*********************************************************
    |                 Products
    |*********************************************************
    */          case 'product':
                    return $this->product();
                break;
                case 'edit-product':
                    return $this->edit_product($data);
                break;
                case 'add-product':
                    return $this->add_product();
                break;
                
                

                
                
    /*
    |*********************************************************
    |                 If Method Not Found
    |*********************************************************
    */            
                default:
                    return redirect('admin');
                break;      
            }
        }
        return redirect('admin');
    }

    /*
    |*********************************************************
    |                   Verify Permission
    |*********************************************************
    */
    public function myMiddleWare($method='')
    {
        $menu=AdminMenu::where('url',$method)->first(['id']);
        if(!empty($menu))
        {  
        
            $permission = DB::table('user_permissions')
                    ->where('role_id',Session::get('bu_user_info')->roles_id)
                    ->whereRaw('FIND_IN_SET(?,menu_id)', [$menu->id])
                    ->orWhereRaw('FIND_IN_SET(?,child_menu_id)', [$menu->id])
                    ->first();
                     
            // echo Session::get('bu_user_info')->roles_id;   
            //  print_r($permission);
            //  die;
            
            if(!empty($permission))
            {
                return "true";
            }
            return "false";  
        } 
        else
        {
            return "true";
        }
    }
    
    /*
    |*********************************************************
    |                   Verify Role
    |*********************************************************
    */
    public function verify()
    {
        if(Session::has('bu_user_info'))
        {
            if(Session::get('bu_user_info')->roles_id==1 || Session::get('bu_user_info')->roles_id==3)
            {
                return true;
            }
        }
        return false;
    }

    /*
    |*********************************************************
    |                   Site Info BackEnd
    |*********************************************************
    */
    public function siteInfo()
    {
        $site_setting=SiteSetting::where('id','1')->first();
        Session::put('bu_site_info',$site_setting);    
    }

    /*
    |*********************************************************
    |                   All Post Methods
    |*********************************************************
    */
    public function postMethods(Request $request,$method='',$id='')
    {
    	return $this->$method($request,$id);
    }


/*
|*********************************************************
|                   All Methods
|*********************************************************
*/
    
    /*
    |*********************************************************
    |                   Admin Profile GET
    |*********************************************************
    */
    public function profile($id='')
    {
        
        $category = Category::where('status',1)->orderBy('id','DESC')->get();
        $profile=User::where('id',Session::get('bu_user_info')->id)->first();
        return view('admin.user.user_profile',compact('profile','category'));
    }
    
    public function saveprofile(Request $request,$id='')
    {
        if(Session::get('bu_user_info')->roles_id == 1)
        {
            $validatedData = Validator::make($request->all(), [
               'name' => 'required',
    		   'email' => 'required|unique:users,email,'.$id,
    		   'password' => 'required',
    		   'mobile' => 'required|numeric',
            ],
        	[
        			'name.required' => 'Please enter name.', 
                    'email.required' => 'Please enter email address.',
        			'email.email' => 'Please enter valid email address.', 
        			'email.unique' => 'Email aleady exist,Please enter different email.',
        			'password.required' => 'Please enter password.',
        		    'mobile.numeric' => 'Please enter mobile number.',
        	]);
        }
        else
        {
            $validatedData = Validator::make($request->all(), [
               'name' => 'required',
    		   'email' => 'required|unique:users,email,'.$id,
    		   'password' => 'required',
    		   'mobile' => 'required|numeric',
    		   'address' => 'required',
    		   'description' => 'required',
            ],
        	[
        			'name.required' => 'Please enter name.', 
                    'email.required' => 'Please enter email address.',
        			'email.email' => 'Please enter valid email address.', 
        			'email.unique' => 'Email aleady exist,Please enter different email.',
        			'password.required' => 'Please enter password.',
        		    'mobile.numeric' => 'Please enter mobile number.',
        		    'address.required' => 'Please enter your address.',
        		    'description.required' => 'Please provide your profile description.',
        	]);
        }
    	
    	if($validatedData->fails())
		{
			return redirect()->back()->with('error_message',$validatedData->messages()->first());           
		}
		else
		{
        $profile_data=User::where('id',$id)->first();

        $target='siteimages/user/';
        $header_logo=$request->file('image');
        if(!empty($header_logo))
        {
            $headerImageName=$header_logo->getClientOriginalName();
            $ext1=$header_logo->getClientOriginalExtension();
            $temp1=explode(".",$headerImageName);
            $newHeaderLogo='co'.rand()."".round(microtime(true)).".".end($temp1);
            $headerTarget='siteimages/user/'.$newHeaderLogo;
            $header_logo->move($target,$newHeaderLogo);

            $profile_data->user_image=$headerTarget;
        }
        $profile_data->name=$request['name'];
        $profile_data->email=$request['email'];
        $profile_data->password=bcrypt($request['password']);
        $profile_data->txtpassword=$request['password'];
        //return $request['mobile'];
        $profile_data->mobile=$request['mobile'];
        $profile_data->description=$request['description'];
        $profile_data->address=$request['address'];
        $profile_data->status=$request['status'];
        $profile_data->delivery_available=$request['delivery_available'];
        
        if(!empty($request['category_id'])){
            $profile_data->category_ids=implode(",",$request['category_id']);
        }
        
        
        
        
        $profile_data->save();
        Session::put('bu_user_info',$profile_data);
        Session::flash('success_message', 'Profile  Updated Successfully!');
        return redirect('admin/profile');   
		}
    }
    public function login1($id='')
    {
     return view('admin.login');
    }
    
    /*
    |*********************************************************
    |                   Admin Login
    |*********************************************************
    */
     public function login(Request $request)
     {
        return(new UsersController)->adminlogin($request);
     }

    /*
    |*********************************************************
    |                   Forgot Password
    |*********************************************************
    */
    public function forgotpass($id='')
    {
            //echo 'welcome';
        return(new UsersController)->forgotpassword();
    }
    public function sendpassword(Request $request, $id='')
    { 
        return(new UsersController)->send($request,$id);
    }

    /*
    |*********************************************************
    |                   Admin Dashboard
    |*********************************************************
    */
    public function dashboard($id='')
    {	
     return view('admin.template.home');
    }

    /*
    |*********************************************************
    |                   Order
    |*********************************************************
    */
    public function orders($id='')
    {
        return (new OrderController)->orders();
    }
    public function view_order($id='')
    {
        return (new OrderController)->view_order($id);
    }
    
    /*
    |*********************************************************
    |                   Delivery Charge
    |*********************************************************
    */
    public function delivery_charge($id='')
    {
        return (new DeliveryChargeController)->delivery_charge();
    }
    public function add_new_charge($id='')
    {
        return (new DeliveryChargeController)->add_new_charge();
    }
    public function updatedeliverycstatus($id='')
    {
        return (new DeliveryChargeController)->updatedeliverycstatus($id);
    }
    public function savecharge(Request $request,$id='')
    {
        return (new DeliveryChargeController)->savecharge($request,$id);
    }
    public function edit_charge($id='')
    {
        return (new DeliveryChargeController)->edit_charge($id);
    }
    public function charge_edit(Request $request,$id='')
    {
       return (new DeliveryChargeController)->charge_edit($request,$id);
    }
    public function deletealldeliveryc(Request $request,$id='')
    {
     return (new DeliveryChargeController)->deletealldeliveryc($request,$id); 
    }

    /*
    |*********************************************************
    |                   Country
    |*********************************************************
    */
    public function country($id='')
    {
        return (new CountryController)->countrylist();
    }

    public function countryadd($id='')
    {
        return (new CountryController)->addcountry();
    }
    public function updatecountrystatus($id='')
    {
        return (new CountryController)->updatestatus($id);
    }
    public function savecountry(Request $request,$id='')
    {
        return (new CountryController)->storecountry($request,$id);
    }
    public function countryedit($id='')
    {
        return (new CountryController)->countryedit($id);
    }
    public function editcountry(Request $request,$id='')
    {
       return (new CountryController)->editcountry($request,$id);
    }
    public function deleteallcountry(Request $request,$id='')
    {
     return (new CountryController)->deleteAll($request,$id); 
    }

    /*
    |*********************************************************
    |                   State
    |*********************************************************
    */
    public function state($id='')
    {
        return (new StateController)->statelist();
    }

    public function updatestatestatus($id='')
    {
        return (new StateController)->updatestatus($id);
    }
    public function stateedit($id='')
    {
        return (new StateController)->stateedit($id);
    }
    public function stateadd($id='')
    {
        return (new StateController)->addstate($id);
    }
    public function savestate(Request $request,$id='')
    {
        return (new StateController)->storestate($request,$id);
    }
    public function editstate(Request $request,$id='')
    {
        return (new StateController)->editstate($request,$id);
    }
    public function deleteallstate(Request $request,$id='')
    {
        return (new StateController)->deleteAll($request,$id);
    }
    public function stateData($id='')
    {  
        return (new StateController)->stateData($_GET['country_id']);
    } 

    /*
    |*********************************************************
    |                   City
    |*********************************************************
    */
    public function city($id='')
    {
     return (new CityController)->citylist(); 
    }
    public function updatecitystatus($id='')
    {
        return (new CityController)->updatestatus($id);
    }
    public function cityedit($id='')
    {
     return (new CityController)->cityedit($id);   
    }
    public function cityadd($id='')
    { 
     return (new CityController)->cityadd();   
    }
    public function savecity(Request $request,$id='')
    {  
        return (new CityController)->storecity($request,$id);
    }
    public function editcity(Request $request,$id='')
    {
        return (new CityController)->editcity($request,$id);
    }
    public function deleteallcity(Request $request,$id='')
    {
        return (new CityController)->deleteAll($request,$id);   
    }

    /*
    |*********************************************************
    |                   Menu
    |*********************************************************
    */
    public function menu($id='')
    {
     return (new AdminMenusController)->menulist(); 
    }
    public function updatemenustatus($id='')
    {
        return (new AdminMenusController)->updatestatus();
    }
    public function deleteallmenu(Request $request,$id='')
    {
        return (new AdminMenusController)->deleteAll($request,$id);
    }
    public function menuedit($id='')
    {
        return (new AdminMenusController)->menuedit($id);
    }
    public function editmenu(Request $request,$id='')
    {
        return (new AdminMenusController)->editmenu($request,$id);
    }
    public function menuadd($id='')
    {
        return (new AdminMenusController)->menuadd($id);
    }
    public function savemenu(Request $request,$id='')
    {
        return (new AdminMenusController)->storemenu($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Drivers
    |*********************************************************
    */
    public function driverList($id='')
    {
        return(new UsersController)->driverList();
    }
    
    public function updatedriversstatus($id='')
    {
        return (new UsersController)->updatedriversstatus();
    }
    
    public function updateDriverInspection($id='')
    {
        return (new UsersController)->updateDriverInspection();
    }
    public function deletealldriver(Request $request,$id='')
    {
        return (new UsersController)->deletealldriver($request,$id);
    }
    
    public function driverProfile($id='')
    { 
        return (new UsersController)->driverProfile($id);
    }
    
    /*
    |*********************************************************
    |                   Service Providers
    |*********************************************************
    */
    public function serviceProvidersList($id='')
    {
        return(new SignupAsProviderController)->serviceProvidersList();
    } 
    
    public function updateprovidersstatus($id='')
    {
        return (new SignupAsProviderController)->updateprovidersstatus();
    }
    
    public function updateInspection($id='')
    {
        return (new SignupAsProviderController)->updateInspection();
    }
    
    public function deleteallprovider(Request $request,$id='')
    {
        return (new SignupAsProviderController)->deleteAll($request,$id);
    }
    public function providerProfile($id='')
    { 
        return (new SignupAsProviderController)->profile($id);
    }

    /*
    |*********************************************************
    |                   User
    |*********************************************************
    */
    public function user($id='')
    {
        return(new UsersController)->userlist();
    } 
    public function updateuserstatus($id='')
    {
        return (new UsersController)->updatestatus();
    }
    public function inspection($id='')
    {
        return (new UsersController)->inspection();
    }

    public function deletealluser(Request $request,$id='')
    {
        return (new UsersController)->deleteAll($request,$id);
    } 
    public function useradd($id='')
    {
        return (new UsersController)->useradd($id);
    }
    public function saveuser(Request $request,$id='')
    {
        return (new UsersController)->storeuser($request,$id);
    }
    public function useredit($id='')
    {
        return (new UsersController)->useredit($id);
    }
    public function edituser(Request $request,$id='')
    {
        return (new UsersController)->edituser($request,$id);
    }
    public function showprofile($id='')
    {
        return (new UsersController)->showprofile($id);
    }
    public function searchuser(Request $request,$id='')
    {
        return (new UsersController)->searchuser($request,$id);
    }

    /*
    |*********************************************************
    |                   Roles
    |*********************************************************
    */ 
    public function role($id='')
    {
        return(new RoleController)->rolelist();
    } 
    public function updaterolestatus($id='')
    {
        return (new RoleController)->updatestatus();
    }
    public function roleadd($id='')
    {
        return (new RoleController)->roleadd($id);
    }
    public function saverole(Request $request,$id='')
    {
        return (new RoleController)->storerole($request,$id);
    }
    public function deleteallrole(Request $request,$id='')
    {
        return (new RoleController)->deleteAll($request,$id);
    }
    public function roleedit($id='')
    {
        return (new RoleController)->roleedit($id);
    }
    public function editrole(Request $request,$id='')
    {
        return (new RoleController)->editrole($request,$id);
    }

    /*
    |*********************************************************
    |                   Permission
    |*********************************************************
    */
    public function permission($id='')
    {   
        $roles=Role::get();
        $menus=AdminMenu::orderBy('id','DESC')->get(); 
        return view('admin.permission.permissionlist',compact('roles','menus'));
    }
    public function getPermission($id='')
    {
        $id=$_GET['role_id'];
        $mains=UserPermission::where('role_id',$id)->first();
        if(!empty($mains))
            Session::put('mains',$mains);
        else
            Session::forget('mains');
    }
    public function permissionData($id='')
    {
        $id=$_GET['role_id'];
        $menus=AdminMenu::get(); 
        $mains=UserPermission::where('role_id',$id)->first();
        $smenus='';
        $m=array();
        $s=array();
        $mains1=$subs1=array();

        if(!empty($mains))
        {
            $smenus=$mains;
            $m=$mains['menu_id'];
            $s=$mains['child_menu_id'];
            $mains1=explode(",",$m);
            $subs1=explode(",",$s);
        }
        if($id!=10)
        {
           echo '<h2> Select Access</h2>';
           foreach($menus as $main_menu)
           {
              if($main_menu->parent_menu_id==0)  
              {
                 echo '
                 <tr>
                 <td>
                 <label for="checkbox" style="width:100%;">
                 <input type="checkbox" class="form-control" id="name" name="privilege[]" value="'.$main_menu->id.'" '; if(in_array($main_menu->id,$mains1)) { echo 'checked'; } echo ' ><strong>'. $main_menu->name.'</strong> </label> </td>
                 </tr>';

                 foreach($menus as $sub_menu)
                 {
                    if($sub_menu->parent_menu_id==$main_menu->id)
                    {
                     echo '<tr style="width:350px; position:relative; ">
                     <td>
                     <label style="margin-left:45px !important;" for="checkbox">
                     <input type="checkbox" class="form-control" name="privilege[]" value="'.$sub_menu->id.'"';
                     if(in_array($sub_menu->id,$subs1)){ echo 'checked';}
                     echo '>
                     <strong>'.$sub_menu->name.'</strong> </label></td>
                     </tr>';
                    }  
                 }    
               }
            }
        }
        else
        {
            echo 
            '<tr>
            <td>Please Select Role</td>
            </tr>';
        }
    }

    public function savepermission(Request $request, $id='')
    {   
        $role_id=$request['role_id'];
        $privileges=$request['privilege'];
        $all=count($privileges);
        $main=array();
        $sub=array();
        if(!empty($privileges))
        {
            foreach($privileges as $data)
            {
             $menu=AdminMenu::where('id',$data)->first();
             if($menu->parent_menu_id=='0')
             {
                $main[]=$data;
            } 
            else
            {
                $sub[]=$data;
            }
        }
    }
    $permission=UserPermission::where('role_id',$role_id)->first();
    if(!empty($permission))
    {
        $permission->menu_id=implode(",",$main);
        $permission->child_menu_id=implode(",",$sub);
        $permission->save();
    }
    else
    {   
        $permission=new UserPermission;
        $permission->role_id=$role_id;
        $permission->menu_id=implode(",",$main);
        $permission->child_menu_id=implode(",",$sub);
        $permission->save();
    }
    return redirect('admin/permission');
    }

    /*
    |*********************************************************
    |                   Job
    |*********************************************************
    */ 
    public function job($id='')
    {
    	$todaydate = date('Y-m-d');
    	$statusupdate = DB::update('update post_job set status = ? where required_date = ? OR required_date < ?',[0,$todaydate,$todaydate]);
        return (new JobController)->joblist();
    }

    public function updatejobstatus($id='')
    {
        return (new JobController)->updatestatus($id);
    }

    public function jobdetail($id='')
    {
        return (new JobController)->jobdetail($id);
    }
    public function deletealljob(Request $request,$id='')
    {
    	
        return (new JobController)->deleteAll($request,$id);
    }

    /*
    |*********************************************************
    |                   Job
    |*********************************************************
    */ 
    public function jobcategory($id='')
    {
        return (new JobCategoryController)->jobcatlist();
    }
    public function updatejobcatstatus($id='')
    {
        return (new JobCategoryController)->updatestatus($id);
    }
    public function addcategory($id='')
    {
        return (new JobCategoryController)->jobcatadd($id);
    }
    public function savejobcat(Request $request,$id='')
    {
        return (new JobCategoryController)->storejobcat($request,$id);
    }
    public function editjobcategory($id='')
    {
        return (new JobCategoryController)->jobcatedit($id);
    }
    public function editjobcat(Request $request,$id='')
    { //print_r($request->all()); die;
        return (new JobCategoryController)->editjobcat($request,$id);
    }
    public function deletealljobcat(Request $request,$id='')
    {
        return (new JobCategoryController)->deleteAll($request,$id);
    }
 
    /*
    |*********************************************************
    |                   Site Settings
    |*********************************************************
    */ 
    public function sitesetting($id='')
    {

        return (new SiteSettingController)->sitesetting($id);  
    }
    public function editsite(Request $request,$id='')
    {
        return (new SiteSettingController)->editsite($request,$id);
    }

    /*
    |*********************************************************
    |                   Pages
    |*********************************************************
    */ 
 
    public function pages($id='')
    {
     return (new PageController)->pagelist(); 
    }
    public function updatepagestatus($id='')
    {
        return (new PageController)->updatestatus();
    }
    public function pageadd($id='')
    {
        return (new PageController)->pageadd();
    }
    public function savepage(Request $request,$id='')
    {
     return (new PageController)->storepage($request,$id); 
    }
    public function deleteallpages(Request $request,$id='')
    {
        return (new PageController)->deleteAll($request,$id);
    }
    public function pageedit($id='')
    {
        return (new PageController)->pageedit($id);
    }
    public function editpage(Request $request,$id='')
    {
        return (new PageController)->editpage($request,$id);
    }
    /*
    |*********************************************************
    |                   Blogs
    |*********************************************************
    */ 
    public function blog($id='')
    {
        return (new BlogController)->bloglist(); 
    }
    public function blogadd($id='')
    {
        return (new BlogController)->blogadd(); 
    }
    public function saveblog(Request $request,$id='')
    {
     return (new BlogController)->storeblog($request,$id); 
    }
    public function updateblogstatus($id='')
    {
        return (new BlogController)->updatestatus($id);
    }
    public function deleteallblog(Request $request,$id='')
    {
        return (new BlogController)->deleteAll($request,$id);
    }
    public function blogedit($id='')
    {
        return (new BlogController)->blogedit($id);
    }
    public function editblog(Request $request,$id='')
    {
        return (new BlogController)->editblog($request,$id);
    }
    /*
    |*********************************************************
    |                   Blog Category
    |*********************************************************
    */ 
    public function blogcategory($id='')
    {
        return (new BlogController)->BlogCategorylist(); 
    }
    public function blog_category_add($id='')
    {
        return (new BlogController)->blog_category_add(); 
    }
    public function saveblogcategory(Request $request,$id='')
    {
     return (new BlogController)->storeblogcategory($request,$id); 
    }
    public function blog_category_edit($id='')
    {
        return (new BlogController)->blog_category_edit($id);
    }
    public function editblogcategory(Request $request,$id='')
    {
        return (new BlogController)->editblogcategory($request,$id);
    }
    public function deleteallbcat(Request $request,$id='')
    {
        return (new BlogController)->deleteAllCategory($request,$id);
    }
    public function updatebcatstatus($id='')
    {
        return (new BlogController)->updatebcatstatus($id);
    }
     
    /*
    |*********************************************************
    |                   Ride Type
    |*********************************************************
    */ 
    public function ridetype($id='')
    {
        return (new RideTypeController)->ridetypelist(); 
    }
    public function ridetypeadd($id='')
    {
        return (new RideTypeController)->ridetypeadd(); 
    }
    public function saveridetype(Request $request,$id='')
    {
        return (new RideTypeController)->storeridetype($request,$id); 
    }
    public function updateridetypestatus($id='')
    {
        return (new RideTypeController)->updatestatus($id);
    }
    public function deleteallridetype(Request $request,$id='')
    {
        return (new RideTypeController)->deleteAll($request,$id);
    }
    public function ridetypeedit($id='')
    {
        return (new RideTypeController)->ridetypeedit($id);
    }
    public function editridetype(Request $request,$id='')
    {
        return (new RideTypeController)->editridetype($request,$id);
    }
    
     /*
    |*********************************************************
    |                  Ride Type Subcategory
    |*********************************************************
    */ 
    public function ride_type_subcategory($id='')
    {
        return (new RideTypeController)->ride_type_subcategory(); 
    }
    public function subcategoryadd($id='')
    {
        return (new RideTypeController)->subcategoryadd(); 
    }
    public function savesubcategory(Request $request,$id='')
    {
        return (new RideTypeController)->savesubcategory($request,$id); 
    }
    public function updatesubcategorystatus($id='')
    {
        return (new RideTypeController)->updatesubcategorystatus($id);
    }
    public function deleteallsubcategory(Request $request,$id='')
    {
        return (new RideTypeController)->deleteallsubcategory($request,$id);
    }
    public function subcategoryedit($id='')
    {
        return (new RideTypeController)->subcategoryedit($id);
    }
    public function editsubcategory(Request $request,$id='')
    {
        return (new RideTypeController)->editsubcategory($request,$id);
    }
    /*
    |*********************************************************
    |                 Ride Type Subcategory
    |*********************************************************
    */ 
    
     
    // return $this->ride_type_subcategory();
     
    // case 'subcategoryedit':
    //     return $this->subcategoryedit($data);
    // break;
    // case 'subcategoryadd':
    //     return $this->subcategoryadd();
    // break;
    // case 'updatesubcategorystatus':
    //     return $this->updatesubcategorystatus($data);
    // break;
    
    // case 'deleteallsubcategory':
    //     return $this->deleteallsubcategory();
    // break;
    
    
    /*
    |*********************************************************
    |                   Services
    |*********************************************************
    */ 
    public function service($id='')
    {
        return (new ServiceController)->servicelist(); 
    } 
    public function serviceadd($id='')
    {
        return (new ServiceController)->serviceadd(); 
    } 
    public function saveservice(Request $request,$id='')
    {
        return (new ServiceController)->storeservice($request,$id); 
    }
    public function updateservicestatus($id='')
    {
        return (new ServiceController)->updatestatus($id);
    }
    public function deleteallservice(Request $request,$id='')
    {
        return (new ServiceController)->deleteAll($request,$id);
    }
    public function serviceedit($id='')
    {
        return (new ServiceController)->serviceedit($id);
    }
    public function editservice(Request $request,$id='')
    {
        return (new ServiceController)->editservice($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Front End Menus
    |*********************************************************
    */ 
    public function frontmenu($id='')
    {
        return (new FrontMenuController)->frontmenulist(); 
    }
    public function updatefrontmenustatus($id='')
    {
        return (new FrontMenuController)->updatestatus($id);
    }
    public function frontmenuedit($id='')
    {
        return (new FrontMenuController)->frontmenuedit($id);
    }
    public function editfrontmenu(Request $request,$id='')
    {
        return (new FrontMenuController)->editfrontmenu($request,$id);
    }
    
    /*
    |*********************************************************
    |                   SmartBlock
    |*********************************************************
    */  
    public function smartblock($id='')
    {
        return (new SmartblockController)->smartblocklist(); 
    }
    public function updatesmartblockstatus($id='')
    {
        return (new SmartblockController)->updatestatus($id);
    }
    public function smartblockadd($id='')
    {
        return (new SmartblockController)->smartblockadd(); 
    } 
    public function savesmartblock(Request $request,$id='')
    {
        return (new SmartblockController)->storesmartblock($request,$id); 
    }
    public function smartblockedit($id='')
    {
        return (new SmartblockController)->smartblockedit($id);
    }
    public function editsmartblock(Request $request,$id='')
    {
        return (new SmartblockController)->editsmartblock($request,$id);
    }
    public function deleteallsmartblock(Request $request,$id='')
    {
        return (new SmartblockController)->deleteAll($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Banner
    |*********************************************************
    */ 
    public function banner($id='')
    {
        return (new BannerController)->bannerlist(); 
    }
    public function updatebannerstatus($id='')
    {
        return (new BannerController)->updatestatus($id);
    }
    public function banneradd($id='')
    {
        return (new BannerController)->banneradd(); 
    }
    public function savebanner(Request $request,$id='')
    {
        return (new BannerController)->storebanner($request,$id); 
    }
    public function banneredit($id='')
    {
        return (new BannerController)->banneredit($id);
    }
    public function editbanner(Request $request,$id='')
    {
        return (new BannerController)->editbanner($request,$id);
    }
    public function deleteallbanner(Request $request,$id='')
    {
        return (new BannerController)->deleteAll($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Reports
    |*********************************************************
    */ 
    public function reports($id='')
    {
        return (new ReportController)->reports(); 
    }
    public function updatereportstatus($id='')
    {
        return (new ReportController)->updatereportstatus($id);
    }
    public function addreport($id='')
    {
        return (new ReportController)->addreport(); 
    }
    public function savereport(Request $request,$id='')
    {
        return (new ReportController)->savereport($request,$id); 
    }
    public function editreport($id='')
    {
        return (new ReportController)->editreport($id);
    }
    public function reportedit(Request $request,$id='')
    {
        return (new ReportController)->reportedit($request,$id);
    }
    public function deleteallreports(Request $request,$id='')
    {
        return (new ReportController)->deleteallreports($request,$id);
    }

    /*
    |*********************************************************
    |                   Comments
    |*********************************************************
    */   
    public function comment($id='')
    {
        return (new CommentController)->commentlist(); 
    }
    public function updatecommentstatus($id='')
    {
        return (new CommentController)->updatestatus($id);
    }
    public function commentedit($id='')
    {
        return (new CommentController)->commentedit($id);
    }
    public function editcomment(Request $request,$id='')
    {
        return (new CommentController)->editcomment($request,$id);
    }
    public function deleteallcomment(Request $request,$id='')
    {
        return (new CommentController)->deleteAll($request,$id);
    }
    
    

    /*
    |*********************************************************
    |                   Plan Duration
    |*********************************************************
    */
    public function duration($id='')
    {
        return (new SubscriptionDurationController)->durationlist(); 
    }
    public function updatedurationstatus($id='')
    {
        return (new SubscriptionDurationController)->updatestatus($id);
    }
    public function durationadd($id='')
    {
        return (new SubscriptionDurationController)->durationadd(); 
    }
    public function saveduration(Request $request,$id='')
    {
        return (new SubscriptionDurationController)->storeduration($request,$id); 
    }
    public function durationedit($id='')
    {
        return (new SubscriptionDurationController)->durationedit($id);
    }
    public function editduration(Request $request,$id='')
    {
        return (new SubscriptionDurationController)->editduration($request,$id);
    }
    public function deleteallduration(Request $request,$id='')
    {
        return (new SubscriptionDurationController)->deleteAll($request,$id);
    }

    /*
    |*********************************************************
    |                   Subscription Plan
    |*********************************************************
    */
    public function plan($id='')
    {
        return (new SubscriptionPlanController)->planlist(); 
    }
    public function updateplanstatus($id='')
    {
        return (new SubscriptionPlanController)->updatestatus($id);
    }
    public function planadd($id='')
    {
        return (new SubscriptionPlanController)->planadd(); 
    }
    public function saveplan(Request $request,$id='')
    {
        return (new SubscriptionPlanController)->storeplan($request,$id); 
    }
    public function planedit($id='')
    {
        return (new SubscriptionPlanController)->planedit($id);
    }
    public function deleteallplan(Request $request,$id='')
    {
        return (new SubscriptionPlanController)->deleteAll($request,$id);
    }
    public function editplan(Request $request,$id='')
    {
        return (new SubscriptionPlanController)->editplan($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Payments
    |*********************************************************
    */
    public function payment($id='')
    {
        return (new BusinessController)->paymentlist();
    }
    public function transection($id='')
    {
        return (new BusinessController)->transectioninfo($id);
    }
    public function subscription($id='')
    {
        return (new SubscriptionPlanController)->subscriptioninfo($id);
    }
    
    /*
    |*********************************************************
    |                   Specialized Business
    |*********************************************************
    */
    public function specializedbusiness($id='')
    {
        return (new SpecializeBusinessController)->specialized_business_list();
    }
    public function update_spbusiness_status($id='')
    {
        return (new SpecializeBusinessController)->updatestatus();
    }
    public function deleteall_spbusiness(Request $request,$id='')
    {
        return (new SpecializeBusinessController)->deleteAll($request,$id);
    }
    public function showbusiness($id='')
    {
        return (new SpecializeBusinessController)->showbusiness($id); 
    }
    
    /*
    |*********************************************************
    |                   Posts
    |*********************************************************
    */
    public function posts($id='')
    {
        return (new PostController)->posts(); 
    }
    public function view_post($id='')
    {
        return (new PostController)->view_post($id);
    }
    
    /*
    |*********************************************************
    |                  Chat Packages
    |*********************************************************
    */
    public function chatpackages($id='')
    {
        return (new ChatPackageController)->chatpackages(); 
    }
     public function updatechatpackagestatus($id='')
    {
        return (new ChatPackageController)->updatechatpackagestatus($id);
    }
    public function add_chatpackage($id='')
    {
        return (new ChatPackageController)->add_chatpackage(); 
    }
    public function save_chatpackage(Request $request)
    {
        return (new ChatPackageController)->save_chatpackage($request); 
    }
    public function edit_chatpackage($id='')
    {
        return (new ChatPackageController)->edit_chatpackage($id);
    }
    public function editchat_package(Request $request,$id='')
    {
        return (new ChatPackageController)->editchat_package($request,$id);
    }
    public function deleteallchatpackages(Request $request,$id='')
    {
        return (new ChatPackageController)->deleteallchatpackages($request,$id);
    }
    
    /*
    |*********************************************************
    |                  News Packages
    |*********************************************************
    */
    public function newspackages($id='')
    {
        return (new NewsPackageController)->newspackages(); 
    }
     public function updatenewspackagestatus($id='')
    {
        return (new NewsPackageController)->updatenewspackagestatus($id);
    }
    public function add_newspackage($id='')
    {
        return (new NewsPackageController)->add_newspackage(); 
    }
    public function save_newspackage(Request $request)
    {
        return (new NewsPackageController)->save_newspackage($request); 
    }
    public function edit_newspackage($id='')
    {
        return (new NewsPackageController)->edit_newspackage($id);
    }
    public function editnews_package(Request $request,$id='')
    {
        return (new NewsPackageController)->editnews_package($request,$id);
    }
    public function deleteallnewspackages(Request $request,$id='')
    {
        return (new NewsPackageController)->deleteallnewspackages($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Packages
    |*********************************************************
    */
    public function packages($id='')
    {
        return (new PackageController)->packages(); 
    }
    public function updatepackagestatus($id='')
    {
        return (new PackageController)->updatepackagestatus($id);
    }
    public function add_package($id='')
    {
        return (new PackageController)->add_package(); 
    }
    public function savepackage(Request $request)
    {
        return (new PackageController)->savepackage($request); 
    }
    public function edit_package($id='')
    {
        return (new PackageController)->edit_package($id);
    }
    public function editpackage(Request $request,$id='')
    {
        return (new PackageController)->editpackage($request,$id);
    }
    public function deleteallpackages(Request $request,$id='')
    {
        return (new PackageController)->deleteallpackages($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Upgrades
    |*********************************************************
    */
    public function upgrades($id='')
    {
        return (new UpgradeController)->upgrades(); 
    }
    public function updateupgradestatus($id='')
    {
        return (new UpgradeController)->updateupgradestatus($id);
    }
    public function add_upgrade($id='')
    {
        return (new UpgradeController)->add_upgrade(); 
    }
    public function saveupgrade(Request $request)
    {
        return (new UpgradeController)->saveupgrade($request); 
    }
    public function edit_upgrade($id='')
    {
        return (new UpgradeController)->edit_upgrade($id);
    }
    public function editupgrade(Request $request,$id='')
    {
        return (new UpgradeController)->editupgrade($request,$id);
    }
    public function deleteallupgrades(Request $request,$id='')
    {
        return (new UpgradeController)->deleteallupgrades($request,$id);
    }
    
    /*
    |*********************************************************
    |                   News
    |*********************************************************
    */
 
    public function news($id='')
    {
        return (new NewsController)->news();
    }
    public function add_news($id='')
    {
        return (new NewsController)->add_news(); 
    }
    public function savenews(Request $request)
    {
        return (new NewsController)->savenews($request); 
    }
     public function edit_news($id='')
    {
        return (new NewsController)->edit_news($id);
    }
    public function editnews(Request $request,$id='')
    {
        return (new NewsController)->editnews($request,$id);
    }
    public function updatenewsstatus($id='')
    {
        return (new NewsController)->updatenewsstatus($id);
    }
    public function deleteallnews(Request $request,$id='')
    {
        return (new NewsController)->deleteallnews($request,$id);
    }

    /*
    |*********************************************************
    |                   Unit
    |*********************************************************
    */
 
    public function unit($id='')
    {
        return (new UnitController)->index();
    }
    public function addunit($id='')
    {
        return (new UnitController)->create(); 
    }
    public function saveunit(Request $request)
    {
        return (new UnitController)->store($request); 
    }
    public function updateunitstatus($id='')
    {
        return (new UnitController)->updatestatus($id);
    }
    public function deleteallunit(Request $request,$id='')
    {
        return (new UnitController)->deleteAll($request,$id);
    }
    public function unitedit($id='')
    {
        return (new UnitController)->edit($id);
    }
    public function editunit(Request $request,$id='')
    {
        return (new UnitController)->update($request,$id);
    }
    
    /*
    |*********************************************************
    |                   Lead
    |*********************************************************
    */
    public function lead($id='')
    {
        return (new LeadController)->index();
    }
    public function leadadd($id='')
    {
        return (new LeadController)->create(); 
    }
    public function savelead(Request $request)
    {
        return (new LeadController)->store($request); 
    }
    public function updateleadstatus($id='')
    {
        return (new LeadController)->updatestatus($id);
    }
    public function deletealllead(Request $request,$id='')
    {
        return (new LeadController)->deleteAll($request,$id);
    }
    public function leadedit($id='')
    {
        return (new LeadController)->edit($id);
    }
    public function editlead(Request $request,$id='')
    {
        return (new LeadController)->update($request,$id);
    }

    /*
    |*********************************************************
    |                   Special Category
    |*********************************************************
    */

    public function special_category($id='')
    {
        return (new SpecialServiceCategoryController)->index();
    }
     public function specialcategoryadd($id='')
    {
        return (new SpecialServiceCategoryController)->create(); 
    }
     
    public function savespecailcategory(Request $request)
    {
        return (new SpecialServiceCategoryController)->store($request); 
    }

    /*
    |*********************************************************
    |                   Subscribers
    |*********************************************************
    */
    public function subscribers()
    {
        $users=User::where('upgraded_business','1')->paginate(10);
        return view('admin.user.allsubscribers',compact('users'));
    }

    /*
    |*********************************************************
    |                   Logout
    |*********************************************************
    */
    public function logout(Request $redirect)
    {
        $this->user_logout();
        return redirect('admin');
    }
    public function user_logout()
    {
        Session::forget('bu_user_info');
        Session::forget('bu_site_info'); 
    }
    
    /*
    |*********************************************************
    |                   Company
    |*********************************************************
    */
    public function companies()
    {
        return (new CompanyController)->companylist();
    }
    public function create_company()
    {
        return (new CompanyController)->create_company();
    }
    public function savecompany(Request $request)
    {
        return (new CompanyController)->savecompany($request);
    }
    public function company_edit($id='')
    {   if(!empty($id))
        {
            return (new CompanyController)->company_edit($id);
        }
        else 
        {
            return redirect('admin/companies');
        }
        
    }
    
     /*
    |*********************************************************
    |                   Offer banner
    |*********************************************************
    */
    public function banners()
    {
        return (new OfferBannerController)->banners();
    }
    public function addbanner()
    {
        return (new OfferBannerController)->addbanner();
    }
    public function save_banner(Request $request)
    {
        return (new OfferBannerController)->save_banner($request);
    }
    
    public function edit_banner($id='')
    {  
            return (new OfferBannerController)->edit_banner($id);
       
    }
    
    public function banner_edit(Request $request, $id)
    {
        return (new OfferBannerController)->banner_edit($request,$id);
    }
    
    public function updatebannersstatus($id='')
    {
        return (new OfferBannerController)->updatebannerstatus($id);
    }
    
    public function deleteallbanners(Request $request,$id='')
    {
        return (new OfferBannerController)->deleteallbanners($request,$id);
    }
    
    
    /*
    |*********************************************************
    |                   Product Category
    |*********************************************************
    */
    public function product_category()
    {
        return (new ProductCategoryController)->product_category();
    }
    public function add_product_category()
    {
        return (new ProductCategoryController)->add_product_category();
    }
    public function saveproduct_cat(Request $request)
    {
        return (new ProductCategoryController)->saveproduct_cat($request);
    }
    public function editproduct_cat(Request $request, $id)
    {
        return (new ProductCategoryController)->editproduct_cat($request,$id);
    }
    public function edit_product_category($id='')
    {  
            return (new ProductCategoryController)->edit_product_category($id);
       
    }
    public function updateproductcatstatus($id='')
    {
        return (new ProductCategoryController)->updateproductcatstatus($id);
    }
    public function deleteallproductcat(Request $request,$id='')
    {
        return (new ProductCategoryController)->deleteallproductcat($request,$id);
    }
    
     /*
    |*********************************************************
    |                   Visit request
    |*********************************************************
    */
    public function visit_request()
    {
    	$visits=FarmVisits::orderBy('id','DESC')->paginate(25);
    	return view('admin.farm_visits.farmvisits',compact('visits'));
    }
    
    /*
    |*********************************************************
    |                  Transactions
    |*********************************************************
    */
    public function transactions()
    { 
        return (new TransactionController)->transactions();
    }
    
    /*
    |*********************************************************
    |                  Property
    |*********************************************************
    */
    public function properties()
    { 
        return (new PropertyController)->properties();
    }
    
    
    public function viewproperty($id='')
    {  
            return (new PropertyController)->viewproperty($id);
       
    }
    
    
    
    
    
     /*
    |*********************************************************
    |                   Products
    |*********************************************************
    */
    public function product()
    {
        return (new ProductController)->product();
    }
    public function add_product()
    {
        return (new ProductController)->add_product();
    }
    public function saveproduct(Request $request)
    {
        return (new ProductController)->saveproduct($request);
    }
    public function editproduct(Request $request, $id)
    {
        return (new ProductController)->editproduct($request,$id);
    }
    public function edit_product($id='')
    {  
            return (new ProductController)->edit_product($id);
       
    }
    public function updateproductstatus($id='')
    {
        return (new ProductController)->updateproductstatus($id);
    }
    public function deleteallproduct(Request $request,$id='')
    {
        return (new ProductController)->deleteallproduct($request,$id);
    }
    
    
     /*
    |*********************************************************
    |                   Certificates
    |*********************************************************
    */
    public function certificates()
    {
        return (new CertificateController)->certificates();
    }
    public function certificateadd()
    {
        return (new CertificateController)->certificateadd();
    }
   public function savecertificate(Request $request)
    {
        return (new CertificateController)->savecertificate($request);
    }
    
    
    public function edit_certificate(Request $request, $id)
    {
        return (new CertificateController)->edit_certificate($request,$id);
    }
    public function certificateedit($id='')
    {  
            return (new CertificateController)->certificateedit($id);
       
    }
    
    public function updatecertificatestatus($id='')
    {echo 'hi'; die;
        return (new CertificateController)->updatecertificatestatus($id);
    }
    public function deleteallcertificate(Request $request,$id='')
    {
        return (new CertificateController)->deleteallcertificate($request,$id);
    }
    
     /*
    |*********************************************************
    |                   Product Subscriptions
    |*********************************************************
    */
    public function product_subscriptions()
    {
        return (new SubscriptionController)->product_subscriptions();
    }
                    
               
}    

