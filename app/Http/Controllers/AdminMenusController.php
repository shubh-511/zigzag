<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminMenu;
use App\UserPermission;
use App\User;
use Session;
use Validator;


class AdminMenusController extends Controller
{
    //
// 	public static function adminMenus($role_id)
// 	{
// 		$menus=AdminMenu::where('status','1')->orderBy('priority','ASC')->get();
//         $spmenus=UserPermission::where('role_id',$role_id)->first();
//         $user=User::where('id',Session::get('userid'))->first();
        
//         Session::put('menus',$menus);
//         Session::put('spmenus',$spmenus);
//         //Session::put('profile_image',$user->user_image);
//     }
    public static function adminMenus($role_id)
	{
	    
		$menus=AdminMenu::where('status','1')->orderBy('priority','ASC')->get();
		Session::put('menus',$menus);
        
        if(Session::get('bu_user_info')->roles_id=='3' && Session::get('bu_user_info')->verify=='0')
        {
            $spmenus=UserPermission::where('role_id','10')->first();  // role 10 for non of user
            Session::put('spmenus',$spmenus);
        }
        else
        {
           $spmenus=UserPermission::where('role_id',$role_id)->first();
            Session::put('spmenus',$spmenus);
        }
        
    }
    public static function menulist()
    {
      $menus=AdminMenu::orderBy('id','DESC')->paginate(10);
      return view('admin.menu.menulist',compact('menus'));
  }
  public static function updatestatus()
  {
      $id=$_GET['id'];
      $status=$_GET['value'];
      $model = AdminMenu::find($id);
      if($model) 
      {
        $model->status = $status;
        $model->save();
    }
        //return redirect('admin/menu');
}
public function deleteAll(Request $request,$id='')
{
    $ids = $request->mul_del;
    AdminMenu::whereIn('id',$ids)->delete();

    Session::flash('message', 'Menu Deleted Successfully !');
    return redirect('admin/menu');
}
public function menuedit($id='')
{
   $pmenus = AdminMenu::Where('parent_menu_id','0')->get();
   $data = AdminMenu::find($id);
   return view('admin.menu.menuedit',compact('data','pmenus'));
}
public function editmenu(Request $request,$id='')
{
    $x = Validator::make($request->all(),['name' => 'required|max:255',]);
    if ($x->fails())
    {
        return redirect()->back()->withInput($request->input())->withErrors($x->errors());
    }
    else
    {
        //$x=$request['id'];                              
        $menu = AdminMenu::find($id);
        $menu->name= $request['name'];
        $menu->url= $request['url'];
       // $menu->controller = $request['controller'];
       // $menu->action = $request['action'];
        $menu->parent_menu_id = $request['parent_menu_id'];
        $menu->icon = $request['icon'];
        $menu->priority = $request['priority'];
        $menu->status = $request['status'];
        
        $menu->save();
        Session::flash('message', 'Menu Updated Successfully!');
        return redirect('admin/menu');
    }  
}
public function menuadd($id='')
{
   $pmenu = AdminMenu::where('parent_menu_id','0')->get(); 
        //return view('admin.menu.create')->with('parent_menu_id',$pmenu);
   return view('admin.menu.menuadd',compact('pmenu'));
}
public function storemenu(Request $request,$id='')
{
    $v = Validator::make($request->all(), [
       'name' => 'required|max:255',
       
   ]);
    if ($v->fails())
    {
       return redirect()->back()->withInput($request->input())->withErrors($v->errors());
   }
   else
   {
     $menu = new AdminMenu;
     $menu->name = $request['name'];
     $menu->url = $request['url'];
     $menu->controller = $request['controller'];
     $menu->action = $request['action'];
     $menu->parent_menu_id = $request['parent_menu_id'];
     $menu->icon = $request['icon'];
     $menu->priority = $request['priority'];
            //$menu->status = $request['status'];
     
     $menu->save();
            // redirect
     Session::flash('message', 'Menu Successfully created !');
     return redirect('admin/menu');
 }
}


}
