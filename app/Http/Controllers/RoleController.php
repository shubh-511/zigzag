<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Session;
use Validator;
class RoleController extends Controller
{
    //
	public function rolelist()
	{
		$roles = Role::paginate(25);
		return view('admin.role.rolelist',compact('roles'));
	}
	public static function updatestatus()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = Role::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }

	public function roleadd($id='')
    {
    	return view('admin.role.roleadd');
    }
    public function storerole(Request $request,$id='')
    {
    	$v = Validator::make($request->all(), [
       				 'name' => 'required|unique:roles|max:255',
       		        ]);
		if ($v->fails())
    	{
      		return redirect()->back()->withInput($request->input())->withErrors($v->errors());
   		}
   		else
   		{
   			$nrole = new Role;
			$nrole->name = $request['name'];
            $nrole->status = $request['status'];
            
            $nrole->save();
            // redirect
            Session::flash('message', 'Role Successfully created !');
            return redirect('admin/role');
        }
    }
    public function deleteAll(Request $request,$id='')
    {
        $ids = $request->mul_del;
        Role::whereIn('id',$ids)->delete();

        Session::flash('message', 'Role Deleted Successfully !');
        return redirect('admin/role');
    }
    public function roleedit($id='')
    {
    	//$id=$a;
		
		$role = Role::find($id);
		return view('admin.role.roleedit',compact('role'));
    }
    public function editrole(Request $request,$id='')
    {
    	$x = Validator::make($request->all(), [
       				 'name' => 'required|max:255',
       		        ]);
		if ($x->fails())
   		{
      		return redirect()->back()->withInput($request->input())->withErrors($x->	errors());
   		}
   		else
   		{
   			$role = Role::find($id);
   			$role->name = $request['name'];
    		$role->status = $request['status'];
    	  
   			$role->save();					 						 	
    		Session::flash('message', 'Role Updated Successfully !');
			   return redirect('admin/role');
    	}  
    }


}
