<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Session;
use Validator;
class PageController extends Controller
{
    //
    public function pagelist()
    {
    	$pages=Page::orderBy('id','DESC')->paginate(10);
    	return view('admin.cms.pages.pagelist',compact('pages'));
    }
    public static function updatestatus()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = Page::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function pageadd()
    {
    	$pages=Page::orderBy('name','ASC')->get();
    	return view('admin.cms.pages.pageadd',compact('pages'));
    }
    public function storepage(Request $request,$id='')
    {
       
        $x = Validator::make($request->all(), [
                    'name' => 'required|unique:pages|max:255',
                    ]);
        if ($x->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($x->    errors());
        }
        else
        {
    	$target='siteimages/page/';
		$shortImage=$request->file('short_des_image');
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo='page'.rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/page/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('short_dec_image');
		}


        $target='siteimages/page/';
        $des_image=$request->file('des_image');
        if(!empty($des_image))
        {
        $headerImageName=$des_image->getClientOriginalName();
        $ext1=$des_image->getClientOriginalExtension();
        $temp1=explode(".",$headerImageName);
        $newHeaderLogo='page'.rand()."".round(microtime(true)).".".end($temp1);
        $des_imageTarget='siteimages/page/'.$newHeaderLogo;
        $des_image->move($target,$newHeaderLogo);
        }
        else
        {
            $des_imageTarget=$request->input('short_dec_image');
        }

		

        $page=new Page;//::where('id','1')->first();
    	$page->name=$request->input('name');
        $page->heading=$request->input('heading');
		$page->slug =str_slug($request['name'],'-');
		$page->short_description=$request->input('short_description');
    	$page->long_description=$request->input('long_description');
    	$page->short_des_image=$short_imageTarget;
        $page->des_image=$des_imageTarget;
		$page->parent_id=$request->input('parent_id');
		$page->metatitle=$request->input('metatitle');
    	$page->metakeyword=$request->input('metakeyword');
    	$page->metadescription=$request->input('metadescription');
        $page->status = $request['status'];
    	$page->save();
        Session::flash('message', 'Page Successfully created !');
		return redirect('admin/pages');
        }
	}
	 public function deleteAll(Request $request,$id='')
    {
        $ids = $request->mul_del;
        Page::whereIn('id',$ids)->delete();
		Session::flash('message', 'Page Deleted Successfully !');
        return redirect('admin/pages');
    }
    public function pageedit($id='')
    {
    	//$id=$a;
		$pages=Page::orderBy('name','ASC')->get();
		$epage = Page::find($id);
		return view('admin.cms.pages.pageedit',compact('epage','pages'));
    }
    public function editpage(Request $request,$id='')
    {

    	$target='siteimages/page/';
        $shortImage=$request->file('short_des_image');
        if(!empty($shortImage))
        {
        $headerImageName=$shortImage->getClientOriginalName();
        $ext1=$shortImage->getClientOriginalExtension();
        $temp1=explode(".",$headerImageName);
        $newHeaderLogo='page'.rand()."".round(microtime(true)).".".end($temp1);
        $short_imageTarget='siteimages/page/'.$newHeaderLogo;
        $shortImage->move($target,$newHeaderLogo);
        }
        else
        {
            $short_imageTarget=$request->input('fshort_des_image');
        }


        $target='siteimages/page/';
        $des_image=$request->file('des_image');
        if(!empty($des_image))
        {
        $headerImageName=$des_image->getClientOriginalName();
        $ext1=$des_image->getClientOriginalExtension();
        $temp1=explode(".",$headerImageName);
        $newHeaderLogo='page'.rand()."".round(microtime(true)).".".end($temp1);
        $des_imageTarget='siteimages/page/'.$newHeaderLogo;
        $des_image->move($target,$newHeaderLogo);
        }
        else
        {
            $des_imageTarget=$request->input('fdes_image');
        }



   			$page = Page::find($id);

   			$page->name = $request['name'];
            $page->heading=$request->input('heading');
    		$page->parent_id = $request['parent_id'];
    		$page->slug =str_slug($request['name'],'-');
    		//$page->slug = //str_slug$request['parent_id'];
    		$page->short_description = $request['short_description'];
    		$page->long_description = $request['long_description'];
			$page->short_des_image=$short_imageTarget;
            $page->des_image=$des_imageTarget;
    		$page->metatitle = $request['metatitle'];
    		$page->metakeyword = $request['metakeyword'];
			$page->metadescription = $request['metadescription'];
			$page->status = $request['status'];
			
			$page->save();					 						 	
    		Session::flash('message', 'Page Updated Successfully !');
			return redirect('admin/pages');
    	   
    }
}
