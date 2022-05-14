<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteSetting;
use Session;
class SiteSettingController extends Controller
{
    //
    public function sitesetting($id='')
    {
    	$sitedata=SiteSetting::first();
    	return view('admin.cms.sitesetting.siteedit',compact('sitedata'));
    }
    public function editsite(Request $request,$id='')
	{

		$target='siteimages/site/';
		$header_logo=$request->file('header_logo');
		if(!empty($header_logo))
		{
    	$headerImageName=$header_logo->getClientOriginalName();
    	$ext1=$header_logo->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo='site'.rand()."".round(microtime(true)).".".end($temp1);
    	$headerTarget='siteimages/site/'.$newHeaderLogo;
    	$header_logo->move($target,$newHeaderLogo);
		}
		else
		{
			$headerTarget=$request->input('header');
		}


    	$footer_logo=$request->file('footer_logo');
    	if(!empty($footer_logo))
 		{
    	$footerImageName=$footer_logo->getClientOriginalName();
    	$ext2=$footer_logo->getClientOriginalExtension();
    	$temp2=explode(".",$footerImageName);
    	$newFooterLogo='site'.rand()."".round(microtime(true)).".".end($temp2);
    	$footerTarget='siteimages/site/'.$newFooterLogo;
    	//$footerTarget='uploads/'.$newfilename;
    	$footer_logo->move($target,$newFooterLogo);
		}
		else
		{
			$footerTarget=$request->input('footer');
		}
    	
    	$sitedata=SiteSetting::where('id','1')->first();
    	$sitedata->site_name=$request->input('site_name');
		$sitedata->header_logo=$headerTarget;
    	$sitedata->floating_text=$request->input('floating_text');
    	$sitedata->site_address=$request->input('site_address');
    	$sitedata->site_mobile=$request->input('site_contact_no');
    	$sitedata->site_email1=$request->input('site_email1');
    	$sitedata->site_email2=$request->input('site_email2');
    	$sitedata->fb_link=$request->input('fb_link');
    	$sitedata->twitter_link=$request->input('twitter_link');
    	$sitedata->youtube_link=$request->input('youtube_link');
    	$sitedata->pin_link=$request->input('pin_link');
    	$sitedata->google_link=$request->input('google_link');
        $sitedata->instagram_link=$request->input('instagram_link');
        $sitedata->dribbble_link=$request->input('dribbble_link');
    	$sitedata->linkedin_link=$request->input('linkedin_link');
    	$sitedata->apple_link=$request->input('apple_link');
        $sitedata->playstore_link=$request->input('playstore_link');
        $sitedata->copy_right=$request->input('copyrights');
    	$sitedata->save();
    	Session::flash('message', 'Site Updated Successfully!');
		return redirect('admin/sitesetting');
	}
    
}
