<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Customization;
use Exception;
use Session;
use Auth;
use Validator;

class CustomisationController extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $custom = Customization::where('provider_id',Auth::user()->id)->get();
	  return view('vendors.customization.list',compact('custom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
	  return view('vendors.customization.add');  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
           'name' => 'required',		  	  
       ],[
			'name.required' => 'Please enter customisation label.',             			
	   ]);

	  $Menu = new Customization();
	  $Menu->name = $request->name;
	  $Menu->status = $request->status;
	  $Menu->provider_id = Auth::user()->id;
	  $Menu->save();	 
	  return redirect()->route('customization.index')->with('success',trans('Saved successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = Customization::where('id',$id)->first();	  
	  return view('vendors.customization.edit',compact('data'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
    }

	public function update_customization(Request $request, $id)
	{
	  $validatedData = $request->validate([
           'name' => 'required',		  	  
       ],[
			'name.required' => 'Please enter customisation label.',             			
	   ]);

	  $Menu = Customization::find($id);
	  $Menu->name = $request->name;
	  $Menu->status = $request->status;	 
	  $Menu->save();	 
	  return redirect()->route('customization.index')->with('success',trans('Saved successfully'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

	public function destroy_all(Request $request)
	{
	  $ids = $request->mul_del;
      Customization::whereIn('id',$ids)->delete();
      return redirect()->route('customization.index')->with('message',trans('Deleted Successfully.'));
	}

	public function update_status(Request $request)
	{
	  $id=$_GET['id'];
      $status=$_GET['value'];
      $model = Customization::find($id);
      if($model) 
      {
        $model->status = $status;
        $model->save();
      }
	}
}
