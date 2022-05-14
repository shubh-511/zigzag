<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\State;
use App\Country;
use Session;
use Validator;
 
class CityController extends Controller
{
    //

    public function citylist()
    {
    $cities = City::with('state')->orderBy('id','DESC')->paginate(10);
    //,function($query) {    })->paginate(25);
    	//echo '<pre>';print_r($cities);

    	return view('admin.city.citylist',compact('cities'));
    }

    
    public function cityadd()
    {	
    	
    	$countries=Country::get();
    	return view('admin.city.cityadd',compact('countries'));
    }
    public function storecity(Request $request,$id='')
    {
        $v = Validator::make($request->all(), [
                     'name' => 'required|unique:cities|max:255',
                    ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        else
        {
    	$city=new City;
    	$city->country_id=$request->input('country_id');
    	$city->state_id=$request->input('state_id');
    	$city->name=$request->input('name');
        $city->city_tax=$request->input('city_tax');
    	$city->status=$request->input('status');
        Session::flash('message', 'City Successfully created !');
    	$city->save();
    	return redirect('admin/city');
        }

    }
    public static function updatestatus()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $model = City::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function cityedit($id='')
    {   

        $countries=Country::get();
        $states=State::where('status','1')->get();
        
        //echo '<pre>';print_r($states);
        $city=City::where('id',$id)->first();
        return view('admin.city.cityedit',compact('city','countries','states'));
    }
    public function editcity(Request $request,$id='')
    {   
        //echo $id;
    	$city=City::where('id',$id)->first();
    	$city->country_id=$request->input('country_id');
    	$city->state_id=$request->input('state_id');
    	$city->name=$request->input('name');
        $city->city_tax=$request->input('city_tax');
    	$city->status=$request->input('status');
        Session::flash('message', 'City Updated Successfully!');
    	$city->save();
    	return redirect('admin/city');
        
       // print_r($city);
    }
    public function deleteAll(Request $request,$id='')
    {
        $ids = $request->mul_del;
        City::whereIn('id',$ids)->delete();

        Session::flash('message', 'City Deleted Successfully !');
        return redirect('admin/city');
    }
     public function cityData($id='')
    {


        $state=State::where('id',$id)->first();
        //Session::put('state_tax',$state_tax);
        $tax=0;
        if(!empty($state))
        {
            $tax=$state->state_tax;
        }

        $state_tax_amt=(Session::get('final_price')*$tax)/100;
        $total= Session::get('final_price')+$state_tax_amt;
        Session::put('total',$total);
        Session::put('state_tax',$state_tax_amt);
        //Session::put('total',$total);
        

        //$id=$_POST['country_id'];
        $cities=City::where('state_id',$id)->get();
        //State option list
        if(!empty($cities))
        {
           echo '<option value="" disabled="">---Select City---</option>';
            foreach($cities as $city)
           {
               echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
            }
        }
        else
        {
        echo '<option value="">City not available</option>';
        }
        
        if($state_tax_amt<1)
            {
            $state_symbol='$ ';
            }
            else
            {
                $state_symbol='$ ';
            }
            
            if($total<1)
            {
            $total_symbol='$ ';
            }
            else
            {
                $total_symbol='$ ';
            }
        echo '~ '.$state_symbol.' '.sprintf('%0.2f',$state_tax_amt).'~ '.$total_symbol.' '.sprintf('%0.2f',$total);
    }
    public function calc_city_tax()
    {
        $tax=0;
        $city=City::where('id',$_GET['city_id'])->first();
        if(!empty($city))
        {
            $tax=$city->city_tax;
        }
    
        
        $city_tax_amt=(Session::get('final_price')*$tax)/100;
        $total= Session::get('final_price')+Session::get('state_tax')+$city_tax_amt;
        Session::put('total',$total);
        
            if($city_tax_amt<1)
            {
            $city_symbol='$ ';
            }
            else
            {
                $city_symbol='$ ';
            }
            
            if($total<1)
            {
            $total_symbol='$ ';
            }
            else
            {
                $total_symbol='$ ';
            }

        echo ' '.$city_symbol.' '.sprintf('%0.2f',$city_tax_amt).'~ '.$total_symbol.' '.sprintf('%0.2f',$total);
    }

}
