<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Exception;
use Session;
use Auth;

class SignupAsProviderController extends Controller
{
  public function __construct()
  { 
  }
  
  public function addUserProvider(Request $request)
  {
    return view('admin.signup_as_provider');
  }
  
  public function PostUserProvider(Request $request)
  {
    $validatedData = $request->validate([
           'provider_name' => 'required',
		   'email' => 'required|email|unique:users',
		   'password' => 'required',
		   'mobile_number' => 'required|numeric',
		   'address' => 'required',
    ],
	[
			'provider_name.required' => 'Please enter name.', 
            'email.required' => 'Please enter email address.',
			'email.email' => 'Please enter valid email address.', 
			'email.unique' => 'Email aleady exist,Please enter different email.',
			'password.required' => 'Please enter password.',
		    'mobile_number.numeric' => 'Please enter mobile number.',
		    'address.required' => 'Please provide a proper address.',
	]);
    
    if($request->input('address') == '0')
    {
        return redirect()->back()->with('err_message','Autocomplete returned place contains no geometry');
    }
    else
    {
    	$user           = new User;
      	$user->name     = ucwords(strtolower($request->provider_name));
      	$user->email    = $request->email;
      	$user->password = bcrypt($request->password);
    	$user->txtpassword = $request->password;  	
      	$user->mobile = $request->mobile_number;
      	$user->address = $request->address;
      	$user->lattitude = $request->lattitude;
      	$user->longitude = $request->longitude;
      	//$user->remember_token = $request->password;
    	$user->roles_id = 3;
    	$user->status = 1;
        if($user->save())
    	{
    	  return redirect(url('admin'))->with('msg','You have successfully registered!');
    	  /*
    	  $rememberToken = $request->password;
    	  if(Auth::guard('web')->attempt(['email' =>$request->email,'password'=>$request->password]))
    	  {
    		 return redirect(url('admin/dashboard'));	
    	  }
    	  */
    	}
    }
  }
  
    public function serviceProvidersList()
	{
		$users = User::whereHas('roles', function($query) {    })->where('roles_id',3)->orderBy('id','DESC')->paginate(20);	
        $usersCount = User::where('roles_id',3)->count();	
		return view('admin.user.providers.providerslist',compact('users','usersCount'));
	}
	
	public function updateprovidersstatus()
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
	
	public function updateInspection()
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
	
	
	public function deleteAll(Request $request,$id='')
    {
        $ids = $request->mul_del;
        User::whereIn('id',$ids)->delete();

        Session::flash('success_message', 'Service provider account deleted successfully!');
        return redirect('admin/service-provider');
    }
    
    public function search_providers()
    {  
        if(!empty($_GET['search']))
          {
                $products=User::where('roles_id', 3)->where(function($q) {
                                $q->where('name','like','%'.$_GET['search'].'%')
                                ->orWhere('email','like','%'.$_GET['search'].'%')
                                ->orWhere('mobile','like','%'.$_GET['search'].'%')
                                ;
                            })->get();
                
          }
          else
          {
              $products=User::where('roles_id',3)->orderBy('id','DESC')->get();
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
			
    
            
            
			echo '<td><a title="View Profile" href="'.url('admin/service-provider/view-profile',[$product->id]).'"><i class="fa fa-desktop"></i></a>';
            echo '</tr>';
                                         
        }
    }
    
    public function profile($id='')
    { 
        $user = User::with('roles')->where('id',$id)->first();
        return view('admin.user.providers.profile',compact('user'));
    }

 
}
