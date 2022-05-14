<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\DeliveryCharge;
use App\Attribute;
use App\ItemAttribute;
use App\Page;
use Validator;
use Session;

class DeliveryChargeController extends Controller
{
 
  public function delivery_charge()
    {
    	$delivery=DeliveryCharge::orderBy('id','DESC')->paginate(10);
    	return view('admin.delivery.list',compact('delivery'));
    }
	
  public function add_new_charge($id='')
	{
	  return view('admin.delivery.add');
	}

  public function savecharge(Request $request,$id='')
    {	
		 $delivery = New DeliveryCharge;		 
			 $x = Validator::make($request->all(),['title' => 'unique:delivery_charges|required|max:255','from_distance' => 'required', 'to_distance' => 'required', 'charges' => 'required']);	
	
		if ($x->fails())
        {
        return redirect()->back()->withInput($request->input())->withErrors($x->errors());
        }
        else
        {                                 
        $delivery->title= $request['title'];
		$delivery->from_distance= $request['from_distance'];
		$delivery->to_distance= $request['to_distance'];
		$delivery->charges= $request['charges'];
		$delivery->status= $request['status'];
        $delivery->save();		
        Session::flash('message', 'Distance Charge Created Successfully!');
        return redirect('admin/delivery-charge');
        }  
    }
  
  public static function updatedeliverycstatus()
	{
		$id=$_GET['id'];
        $status=$_GET['value'];
        $model = DeliveryCharge::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
        
	}
	
  public function edit_charge($id='')
    {
    	if($id!=''){
		 $delivery = DeliveryCharge::find($id);
          return view('admin.delivery.edit',compact('delivery'));
		}else{
			return redirect()->back();
		}
    }
	
  public function charge_edit(Request $request,$id='')
    {	
		 $delivery = DeliveryCharge::where('id',$id)->first();
		 if($delivery->title==$request['title']){
			$x = Validator::make($request->all(),['title' => 'required|max:255','from_distance' => 'required', 'to_distance' => 'required', 'charges' => 'required']); 
		 }else{
			 $x = Validator::make($request->all(),['title' => 'unique:delivery_charges|required|max:255','from_distance' => 'required', 'to_distance' => 'required', 'charges' => 'required']);
		 }
	
		
		if ($x->fails())
        {
        return redirect()->back()->withInput($request->input())->withErrors($x->errors());
        }
        else
        {                                   
       
        $delivery->title= $request['title'];
		$delivery->from_distance= $request['from_distance'];
		$delivery->to_distance= $request['to_distance'];
		$delivery->charges= $request['charges'];
		$delivery->status= $request['status'];
        $delivery->save();		
        Session::flash('message', 'Distance Charge Created Successfully!');
        return redirect('admin/delivery-charge');
        
        }  
    }
	
  public function deletealldeliveryc(Request $request,$id='')
    {
		
        $ids = $request->mul_del;
        DeliveryCharge::whereIn('id',$ids)->delete();
        Session::flash('message', 'Distance Charge Deleted Successfully !');
        return redirect('admin/delivery-charge');
    }

}
