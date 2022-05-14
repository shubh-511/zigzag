<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FrontMenu;
use App\Page;
use Session;
class FrontMenuController extends Controller
{
    //
	public function frontmenulist()
	{
		$frontmenus=FrontMenu::orderBy('id','DESC')->paginate(10);
		return view('admin.cms.frontmenu.frontmenulist',compact('frontmenus'));
	}
	public static function updatestatus()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = FrontMenu::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
        //return redirect('admin/menu');
	}
	public function frontmenuedit($id='')
    {
    	$pages = Page::get();
        $frontmenu = FrontMenu::find($id);
        return view('admin.cms.frontmenu.frontmenuedit',compact('frontmenu','pages'));
    }

   /* public function savepermission(Request $request, $id='')
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
*/



    public function editfrontmenu(Request $request, $id='')
    {   
         
       $privileges=$request['privilege'];
        $all=count($privileges);
        //$pages=array();
        
        if(!empty($privileges))
        {
        	$frontmenu=FrontMenu::where('id',$id)->first();
            $frontmenu->name=$request['name'];
            $frontmenu->page_id=implode(",",$privileges);
            $frontmenu->status=$request['status'];
            $frontmenu->save(); 
            
        }
        /*$frontmenu=FrontMenu::where('page_id',$id)->first();
        if(!empty($frontmenu))
        {
            $frontmenu->page_id=implode(",",$pages);
            $frontmenu->save();
        }*/
        /*else
        {   
            $permission=new UserPermission;
            $permission->role_id=$role_id;
            $permission->menu_id=implode(",",$main);
            $permission->child_menu_id=implode(",",$sub);
            $permission->save();
        }*/
        Session::flash('message','Front Menu Updated Successfully !');
        return redirect('admin/frontmenu');
    }

}
