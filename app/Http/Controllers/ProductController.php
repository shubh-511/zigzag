<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Country;
use App\ProvidersMenus;
use Session;
use App\DishCustomisation;
use App\Customization;
use Auth;
use App\Cart;
use Validator;
 
class ProductController extends Controller
{
   public function product()
   {
       if(Auth::user()->id == 1)
       {
            $products = Product::orderBy('id','DESC')->paginate(25);
            $productsCount = Product::count();
       }
       else
       {
            $products = Product::where('added_by',Auth::user()->id)->orderBy('id','DESC')->paginate(25);
            $productsCount = Product::where('added_by',Auth::user()->id)->count();
       }
       return view('admin.product.list',compact('products','productsCount'));
   }
   
   public function add_product()
   {
       if(Auth::user()->roles_id == 3)
       {
           $menus = ProvidersMenus::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
	       $custom = Customization::where('provider_id',Auth::user()->id)->where('status',1)->get();
       }
       else
       {
           $menus = ProvidersMenus::orderBy('id','DESC')->get();
	       $custom = Customization::where('status',1)->get();
       }
	  
    return view('admin.product.add',compact('menus','custom'));
   }

    public function saveproduct(Request $request,$id='')
    {
       
        $v = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'img' => 'required',
            'description' => 'required',
            'product_cat_id' => 'required',
        ],
        [
		'name.required' => 'Please enter the product name',
		'price.numeric' => 'Price field must be numeric',
		'img.required' => 'The image of the product is required',
		'description.required' => 'The description field is required',
		'product_cat_id.required' => 'Please select the menu of this product',
		
		]);
        if ($v->fails())
        {
            return redirect()->back()->with('error_message',$v->messages()->first());
        }
        else
        {
            
        $target='siteimages/product/';
		$shortImage=$request->file('img');
		if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/product/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('img');
		}
            
    	$city=new Product;
    	$city->name=ucwords(strtolower($request->input('name')));
        $city->product_cat_id=$request->input('product_cat_id');
        $city->added_by=Auth::user()->id;
        $city->img=$short_imageTarget;
        $city->description=$request->input('description');
        $city->is_customisable=$request->input('is_customisable');
        $city->price=$request->input('price');
    	$city->status=$request->input('status');
        Session::flash('message', 'Product Successfully created !');
    	$city->save();
    	
    	if($request->input('is_customisable') == 1)
        {
            $lab=array(); $dt=array(); $key_val=array(); 
    		if(!empty($request->custom) && count($request->custom) > 0)
    		{
    			$custom=0;$type=0;$prices=0;
    			foreach($request->custom as $customs){
                $lab[$custom++]=$customs;          
                }
                foreach($request->type as $types){
                $dt[$type++]=$types;          
                }
                foreach($request->prices as $pricess){
                $key_val[$prices++]=$pricess;          
                }
    		}
    		for($i=0; $i<count($lab); $i++)
    		{
    		    $dishCustomisation = new DishCustomisation();
    		    $dishCustomisation->product_id=$city->id;
    		    $dishCustomisation->cutomisation = $lab[$i];
			    $dishCustomisation->type = $dt[$i];
			    $dishCustomisation->prices = $key_val[$i];
			    $dishCustomisation->save();
    		}
        
        }
    	
    	return redirect('admin/product');
        }

    }
    public static function updateproductstatus()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $model = Product::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function edit_product($id='')
    {   
        if(Auth::user()->roles_id == 3)
        {
            $product=Product::where('id',$id)->first();
            $added_by = $product->added_by;
            $menus = ProvidersMenus::where('user_id', $added_by)->orderBy('id','DESC')->get();
            
            $custom = Customization::where('provider_id',Auth::user()->id)->where('status',1)->get();
            $dishCust=DishCustomisation::where('product_id',$id)->get();
        }
        else
        {
            $product=Product::where('id',$id)->first();
            $added_by = $product->added_by;
            $menus = ProvidersMenus::where('user_id', $added_by)->orderBy('id','DESC')->get();
            
            $custom = Customization::where('status',1)->get();
            $dishCust=DishCustomisation::where('product_id',$id)->get();
        }
        
    return view('admin.product.edit',compact('product','menus','dishCust','custom'));
    }
    public function editproduct(Request $request,$id='')
    {   
        $v = Validator::make($request->all(), [
            'product_cat_id' => 'required',
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'img' => 'required',
            
            
        ],
        [
		'name.required' => 'Please enter the product name',
		'price.numeric' => 'Price field must be numeric',
		'img.required' => 'The image of the product is required',
		'description.required' => 'The description field is required',
		'product_cat_id.required' => 'Please select the category of this product',
		
		]);
        if ($v->fails())
        {
            return redirect()->back()->with('error_message',$v->messages()->first());
        }
        else
        {
            $target='siteimages/product/';
    		$shortImage=$request->file('img');
    		if(!empty($shortImage))
    		{
        	$headerImageName=$shortImage->getClientOriginalName();
        	$ext1=$shortImage->getClientOriginalExtension();
        	$temp1=explode(".",$headerImageName);
        	$newHeaderLogo=rand()."".round(microtime(true)).".".end($temp1);
        	$short_imageTarget='siteimages/product/'.$newHeaderLogo;
        	$shortImage->move($target,$newHeaderLogo);
    		}
    		else
    		{
    			$short_imageTarget=$request->input('img');
    		}
            
        	$city=Product::where('id',$id)->first();
            $city->img=$short_imageTarget;
            $city->description=$request->input('description');
        	$city->name=ucwords(strtolower($request->input('name')));
        	$city->product_cat_id=$request->input('product_cat_id');
        	$city->price=$request->input('price');
        	$city->is_customisable=$request->input('is_customisable');
        	$city->status=$request->input('status');
        	$city->save();
        	
        	if($request->input('is_customisable') == 1)
            {
                $lab=array(); $dt=array(); $key_val=array(); 
        		if(!empty($request->custom) && count($request->custom) > 0)
        		{
        			$custom=0;$type=0;$prices=0;
        			foreach($request->custom as $customs){
                    $lab[$custom++]=$customs;          
                    }
                    foreach($request->type as $types){
                    $dt[$type++]=$types;          
                    }
                    foreach($request->prices as $pricess){
                    $key_val[$prices++]=$pricess;          
                    }
                    
                    $existaudio= DishCustomisation::where('product_id',$id)->delete();
                    
        		}
        		for($i=0; $i<count($lab); $i++)
        		{
        		    $dishCustomisation = new DishCustomisation();
        		    $dishCustomisation->product_id=$id;
        		    $dishCustomisation->cutomisation = $lab[$i];
    			    $dishCustomisation->type = $dt[$i];
    			    $dishCustomisation->prices = $key_val[$i];
    			    $dishCustomisation->save();
        		}
            
            }
        	
        	Session::flash('message', 'Product Updated Successfully!');
        	return redirect('admin/product');
        }
        
    }
    public function deleteallproduct(Request $request,$id='')
    {
        $ids = $request->mul_del;
        Product::whereIn('id',$ids)->delete();
        
        Cart::whereIn('product_id',$ids)->delete();

        Session::flash('message', 'Product Deleted Successfully !');
        return redirect('admin/product');
    }
    
    
    public function customisation(Request $request)
    {
        $custom = Customization::where('provider_id',Auth::user()->id)->where('status',1)->get();
        echo '<tr>';
        echo '<td>';
        echo '<select class="form-control" name="custom[]" required>
            <option value="">--Select--</option>';    
            foreach($custom as $customs)
        echo '<option value="'.$customs->id.'"> '.$customs->name.'</option>';

        echo '</select> ';
        echo '</td>';
        echo '<td>';
        echo '<input type="text" name="type[]" class="form-control">';
        echo '</td>';
        echo '<td> ';
        echo '<input type="text" name="prices[]" class="form-control">';
        echo '</td>';
        echo '</tr>';
    }
        
    

}
