<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\State;
use App\City;
use App\Flag;
use Session;
use Validator;
class CountryController extends Controller
{
    //

    public function countrylist()
    {
    	$countries=Country::orderBy('id','DESC')->paginate(10);
    	return view('admin.country.countrylist',compact('countries'));
    }

    public function addcountry()
    {
    	return view('admin.country.countryadd');
    }

    public function storecountry(Request $request, $id='')
    {
         $v = Validator::make($request->all(), [
                     'name' => 'required|unique:countries|max:255',
                     'country_code' => 'required',
                     'flag_image' => 'required',
                     //'email' => 'required|unique:users|max:255',
                     //'password' => 'required|min:8',
                    ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        else
        {
    		$country=new Country;
    		
    		$target='siteimages/flags/';
            $header_logo=$request->file('flag_image');
              
              if(!empty($header_logo))
              {
                  $headerImageName=$header_logo->getClientOriginalName();
                  $ext1=$header_logo->getClientOriginalExtension();
                  $temp1=explode(".",$headerImageName);
                  $newHeaderLogo='flag'.rand()."".round(microtime(true)).".".end($temp1);
                  $headerTarget='siteimages/flags/'.$newHeaderLogo;
                  $header_logo->move($target,$newHeaderLogo);
                  
                  $country->flag_image=$headerTarget;
              }
               
    		$country->name=$request->input('name');
    		$country->country_code=$request->input('country_code');
    		$country->status=$request->input('status');
    		
    		$country->save();
    		//echo '<pre>';print_r($country);
    		Session::flash('message', 'Country Successfully added!');
    		return redirect('admin/country');
    		//return redirect('admin/dashboard');
        }

    }
    public static function updatestatus()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $model = Country::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function countryedit($id='')
    {
        $country=Country::where('id',$id)->first();
        return view('admin.country.countryedit',compact('country'));

    }

    public function editcountry(Request $request, $id='')
    {
        $country=Country::where('id',$id)->first();
        
            $target='siteimages/flags/';
            $header_logo=$request->file('flag_image');
              
              if(!empty($header_logo))
              {
                  $headerImageName=$header_logo->getClientOriginalName();
                  $ext1=$header_logo->getClientOriginalExtension();
                  $temp1=explode(".",$headerImageName);
                  $newHeaderLogo='flag'.rand()."".round(microtime(true)).".".end($temp1);
                  $headerTarget='siteimages/flags/'.$newHeaderLogo;
                  $header_logo->move($target,$newHeaderLogo);
                  
                  $country->flag_image=$headerTarget;
              }
               
    		
        $country->name=$request->input('name');
        $country->country_code=$request->input('country_code');
        $country->status=$request->input('status');
        
        $country->save();
        Session::flash('message', 'Country Updated Successfully !');
        return redirect('admin/country');

    }
    public function deleteAll(Request $request,$id='')
    {
        $ids = $request->mul_del;
        Country::whereIn('id',$ids)->delete();
        State::whereIn('country_id',$ids)->delete();
        City::whereIn('country_id',$ids)->delete();
        Session::flash('message', 'Country Deleted Successfully !');
        return redirect('admin/country');
    }
/*
*==================== Flags List ======================
*/  public function country_flags()
    {
        //return 'Working...';
        $flags=Flag::with('country')->orderBy('id','DESC')->paginate(10);
        return view('admin.flag.flags_list')->with('flags',$flags);
    }
 
}
