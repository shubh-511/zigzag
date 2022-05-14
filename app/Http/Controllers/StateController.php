<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
use App\Country;
use Session;
use Validator;
class StateController extends Controller
{
    //
    public function statelist()
    {
    	$states = State::with('country')->orderBy('id','DESC')->paginate(10);//,function($query) {    })->paginate(25);	
    	
		//$data = User::whereHas('roles', function($query) {    })->paginate(25);	

    	//$states=State::get();
    	//echo '<pre>';print_r($states);
    	return view('admin.state.statelist',compact('states'));
    }

    public function stateedit($id='')
    {
    	$state=State::where('id',$id)->first();
    	$countries=Country::get();	
        return view('admin.state.stateedit',compact('state','countries'));

    }

    public function addstate($id='')
    {	
    	$countries=Country::get();
    	return view('admin.state.stateadd',compact('countries'));
    }
    public function storestate(Request $request,$id='')
    {$v = Validator::make($request->all(), [
                     'name' => 'required|unique:states|max:255',
                    ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        }
        else
        {
    	$state=new State;
    	$state->country_id=$request->input('country_id');
    	$state->name=$request->input('name');
        $state->state_tax=$request->input('state_tax');
    	$state->status=$request->input('status');
    	 
    	$state->save();
    	Session::flash('message', 'State Successfully created !');
    	return redirect('admin/state');
        }
    }
    public static function updatestatus()
    {
        $id=$_GET['id'];
        $status=$_GET['value'];
        $model = State::find($id);
        if($model) 
        {
            $model->status = $status;
            $model->save();
        }
    }
    public function editstate(Request $request,$id='')
    {
    	$state=State::where('id',$id)->first();
    	$state->country_id=$request->input('country_id');
    	$state->name=$request->input('name');
        $state->state_tax=$request->input('state_tax');
    	$state->status=$request->input('status');

    	$state->save();
    	 Session::flash('message', 'State Updated Successfully!');
    	return redirect('admin/state');
    	



    }
    public function deleteAll(Request $request,$id='')
    {
    	$ids = $request->mul_del;
        State::whereIn('id',$ids)->delete();
        City::whereIn('state_id',$ids)->delete();
        Session::flash('message', 'State Deleted Successfully !');
        return redirect('admin/state');
    }
    public function stateData($id='')
    {
    	//$id=$_POST['country_id'];
    	$states=State::where('country_id',$id)->get();
    	
    	//State option list
    	
    	if(!empty($states))
    	{
    		echo '<option value="">Select state</option>';

    	foreach($states as $state)
    	{
    		echo '<option value="'.$state['id'].'">'.$state['name'].'</option>';
        }
    }
    	else
    	{
        echo '<option value="">State not available</option>';
    	}
    	
    }
}
