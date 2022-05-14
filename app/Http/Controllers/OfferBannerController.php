<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\State;
use App\Country;
use App\OfferBanner;
use Session;
use Validator;
 
class OfferBannerController extends Controller
{
    //

    public function banners()
    {
        $banners = OfferBanner::orderBy('id','DESC')->paginate(25);
       	return view('admin.offer_banners.list',compact('banners'));
    }

    
    public function addbanner()
    {	
    	
    	return view('admin.offer_banners.add');
    }
    public function save_banner(Request $request,$id='')
    {
        $target='siteimages/banner/';
		$shortImage=$request->file('img');
        $v = Validator::make($request->all(), [
                     'name' => 'required|unique:offer_banners|max:255',
                    ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        /*elseif($shortImage->getClientOriginalExtension() != 'png' || $shortImage->getClientOriginalExtension() != 'jpg' || $shortImage->getClientOriginalExtension() != 'jpeg')
        {
            Session::flash('err_message', 'Image should be jpg or png format!');
            return redirect()->back(); 
        }*/
        else
        {
            
            
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/banner/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('img');
		}
		
    	$city=new OfferBanner;
    	$city->name=$request->input('name');
        $city->type=$request->input('type');
    	$city->status=$request->input('status');
    	$city->img=$short_imageTarget;
        Session::flash('message', 'Banner Successfully created !');
    	$city->save();
    	return redirect('admin/banners');
        }

    }
    public static function updatebannerstatus()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $model = OfferBanner::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function edit_banner($id='')
    {   

        $banner=OfferBanner::where('id',$id)->first();
        return view('admin.offer_banners.edit',compact('banner'));
    }
    public function banner_edit(Request $request,$id='')
    {   
        $target='siteimages/banner/';
		$shortImage=$request->file('img');
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/banner/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('img');
		}
		
    	$city=OfferBanner::where('id',$id)->first();
        $city->img=$short_imageTarget;
    	$city->name=$request->input('name');
    	$city->status=$request->input('status');
    	$city->type=$request->input('type');
        Session::flash('message', 'Banner Updated Successfully!');
    	$city->save();
    	return redirect('admin/banners');
        
    }
    public function deleteallbanners(Request $request,$id='')
    {
        $ids = $request->mul_del;
        OfferBanner::whereIn('id',$ids)->delete();

        Session::flash('message', 'Banner Deleted Successfully !');
        return redirect('admin/banners');
    }
    
    

}
