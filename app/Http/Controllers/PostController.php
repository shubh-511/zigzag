<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Country;
use App\Post;
use Session;
use App\Upgrade;
use Validator;
 
class PostController extends Controller
{
    //

    public function posts()
    {
        $posts = Post::orderBy('id','DESC')->paginate(25);
       	return view('admin.posts.list',compact('posts'));
    }

    
    public function add_upgrade()
    {	
        
    	return view('admin.upgrade.add');
    }
    public function saveupgrade(Request $request,$id='')
    {
        
        $v = Validator::make($request->all(), [
                     'title' => 'required|unique:upgrades|max:255',
                     
                    ],
                    [
					
					]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
       
        else
        {
            
            $target='siteimages/upgrades/';
		$shortImage=$request->file('img');
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/upgrades/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('img');
		}
            
    	$city=new Upgrade;
    	$city->title=ucwords(strtolower($request->input('title')));
        
        $city->img=$short_imageTarget;
        $city->description=$request->input('description');
        
    	$city->status=$request->input('status');
        Session::flash('message', 'Successfully Added!');
    	$city->save();
    	return redirect('admin/upgrades');
        }

    }
    public static function updateupgradestatus()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $model = Upgrade::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function view_post($id='')
    {   
        
        $post=Post::where('id',$id)->first();
        return view('admin.posts.showpost',compact('post'));
    }
    public function editupgrade(Request $request,$id='')
    {   
        
        $target='siteimages/upgrades/';
		$shortImage=$request->file('img');
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/upgrades/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('img');
		}
        
    	$city=Upgrade::where('id',$id)->first();
        $city->img=$short_imageTarget;
        $city->description=$request->input('description');
        
    	$city->title=ucwords(strtolower($request->input('title')));
    	
    	$city->status=$request->input('status');
        Session::flash('message', 'Updated Successfully!');
    	$city->save();
    	return redirect('admin/upgrades');
        
    }
    public function deleteallupgrades(Request $request,$id='')
    {
        $ids = $request->mul_del;
        Upgrade::whereIn('id',$ids)->delete();
        
        

        Session::flash('message', 'Deleted Successfully!');
        return redirect('admin/upgrades');
    }
    
    

}
