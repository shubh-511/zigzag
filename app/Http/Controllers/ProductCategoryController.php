<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\State;
use App\Country;
use Session;
use Validator;
 
class ProductCategoryController extends Controller
{
    //

    public function product_category()
    {
        $product_cats = Category::orderBy('id','DESC')->paginate(25);
       	return view('admin.product_category.list',compact('product_cats'));
    }

    
    public function add_product_category()
    {	
    	
    	return view('admin.product_category.add');
    }
    public function saveproduct_cat(Request $request,$id='')
    {
        $v = Validator::make($request->all(), [
                     'name' => 'required|unique:categories|max:255',
                    ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        else
        {
            
            $target='siteimages/product_category/';
		$shortImage=$request->file('cat_img');
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/product_category/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('cat_img');
		}
		
    	$city=new Category;
    	$city->name=ucwords(strtolower($request->input('name')));
        
    	$city->status=$request->input('status');
    	$city->cat_img=$short_imageTarget;
        Session::flash('message', 'Category Successfully created !');
    	$city->save();
    	return redirect('admin/product-category');
        }

    }
    public static function updateproductcatstatus()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $model = Category::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function edit_product_category($id='')
    {   

        $product_cat=Category::where('id',$id)->first();
        return view('admin.product_category.edit',compact('product_cat'));
    }
    public function editproduct_cat(Request $request,$id='')
    {   
        $target='siteimages/product_category/';
		$shortImage=$request->file('cat_img');
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/product_category/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('cat_img');
		}
		
    	$city=Category::where('id',$id)->first();
        $city->cat_img=$short_imageTarget;
    	$city->name=ucwords(strtolower($request->input('name')));
    	$city->status=$request->input('status');
    	
        Session::flash('message', 'Category Updated Successfully!');
    	$city->save();
    	return redirect('admin/product-category');
        
    }
    public function deleteallproductcat(Request $request,$id='')
    {
        $ids = $request->mul_del;
        Category::whereIn('id',$ids)->delete();

        Session::flash('message', 'Category Deleted Successfully !');
        return redirect('admin/product-category');
    }
    
    

}
