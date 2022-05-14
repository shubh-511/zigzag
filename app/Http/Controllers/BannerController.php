<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Page;
use Validator;
use Session;

class BannerController extends Controller
{
    //
    public function bannerlist()
    {
    	$banners=Banner::with('pages')->orderBy('id','DESC')->paginate(10);
    	return view('admin.cms.banner.bannerlist',compact('banners'));
    }
    public static function updatestatus()
    {
      $id=$_GET['id'];
      $status=$_GET['value'];
      $model = Banner::find($id);
      if($model) 
      {
        $model->status = $status;
        $model->save();
    }
        //return redirect('admin/menu');
}
public function banneradd()
{
  $pages=Page::where('status','1')->orderBy('name','ASC')->get();
  return view('admin.cms.banner.banneradd',compact('pages'));
}

public function storebanner(Request $request,$id='')
{
   
   $v = Validator::make($request->all(), [
    'name' => 'required|unique:banners|max:255',
       		         //'email' => 'required|unique:users|max:255',
       		         //'password' => 'required|min:8',
]);
   if ($v->fails())
   {
    return redirect()->back()->withInput($request->input())->withErrors($v->errors());
}
else
{
  $target='siteimages/banner/';
  $header_logo=$request->file('image');
  
  if(!empty($header_logo))
  {
      $headerImageName=$header_logo->getClientOriginalName();
      $ext1=$header_logo->getClientOriginalExtension();
      $temp1=explode(".",$headerImageName);
      $newHeaderLogo='banner'.rand()."".round(microtime(true)).".".end($temp1);
      $headerTarget='siteimages/banner/'.$newHeaderLogo;
      $header_logo->move($target,$newHeaderLogo);
  }
  else
  {
     $headerTarget="";
 }



 $nbanner = new Banner;
 $nbanner->name = $request['name'];
 $nbanner->placeholder = $request['placeholder'];
 $nbanner->content = $request['content'];
 $nbanner->file =$headerTarget; 
 $nbanner->page_id= $request['page'];
 $nbanner->status = $request['status'];
 
 $nbanner->save();
            // redirect
 Session::flash('message', 'Banner Successfully created !');
 return redirect('admin/banner');
}
}
public function deleteAll(Request $request,$id='')
{
    $ids = $request->mul_del;
    Banner::whereIn('id',$ids)->delete();
    Session::flash('message', 'Banner Deleted Successfully !');
    return redirect('admin/banner');
}
public function banneredit($id='')
{   
    $pages=Page::get();
    $banner=Banner::find($id);
    return view('admin.cms.banner.banneredit',compact('pages','banner'));
}

public function editbanner(Request $request,$id='')
{
  $target='siteimages/banner/';
  $header_logo=$request->file('image');
  if(!empty($header_logo))
  {
    $headerImageName=$header_logo->getClientOriginalName();
    $ext1=$header_logo->getClientOriginalExtension();
    $temp1=explode(".",$headerImageName);
    $newHeaderLogo='banner'.rand()."".round(microtime(true)).".".end($temp1);
    $headerTarget='siteimages/banner/'.$newHeaderLogo;
    $header_logo->move($target,$newHeaderLogo);
}
else
{
    $headerTarget=$request->input('fimage');
}

$nbanner = Banner::find($id);
$nbanner->name = $request['name'];
$nbanner->placeholder = $request['placeholder'];
$nbanner->content = $request['content'];
$nbanner->file =$headerTarget; 
$nbanner->page_id = $request['page'];
$nbanner->status = $request['status'];



$nbanner->save();                                              
Session::flash('message', 'Banner Updated Successfully !');
return redirect('admin/banner');

}
}
