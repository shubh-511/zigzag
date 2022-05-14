<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\ProvidersMenus;
use Exception;
use Session;
use Auth;
use Validator;

class ProviderMenuController extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $menus = ProvidersMenus::where('user_id',Auth::user()->id)->get();
	  return view('vendors.provider-menu.menu-list',compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
	  return view('vendors.provider-menu.menu-add');  
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
			'name.required' => 'Please enter menu name.',             			
	   ]);
        $shortImage=$request->file('menu_icon');
        $target='siteimages/menu/';
	   if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo='menu'.rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/menu/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('menu_icon');
		}
	  $Menu = new ProvidersMenus();
	  $Menu->menu_name = $request->name;
	  $Menu->status = $request->status;
	  $Menu->menu_icon = $short_imageTarget;
	  $Menu->user_id = Auth::user()->id;
	  $Menu->save();	 
	  return redirect()->route('provider-menu.index')->with('success',trans('Saved successfully'));
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
      $data = ProvidersMenus::where('id',$id)->first();	  
	  return view('vendors.provider-menu.menu-edit',compact('data'));  
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

	public function update_menu(Request $request, $id)
	{
	  $validatedData = $request->validate([
           'name' => 'required',		  	  
       ],[
			'name.required' => 'Please enter menu name.',             			
	   ]);
	   $shortImage=$request->file('menu_icon');
	   $target='siteimages/menu/';
	   if(!empty($shortImage))
		{
    	$headerImageName=$shortImage->getClientOriginalName();
    	$ext1=$shortImage->getClientOriginalExtension();
    	$temp1=explode(".",$headerImageName);
    	$newHeaderLogo='menu'.rand()."".round(microtime(true)).".".end($temp1);
    	$short_imageTarget='siteimages/menu/'.$newHeaderLogo;
    	$shortImage->move($target,$newHeaderLogo);
		}
		else
		{
			$short_imageTarget=$request->input('menu_icon');
		}

	  $Menu = ProvidersMenus::find($id);
	  $Menu->menu_name = $request->name;
	  $Menu->status = $request->status;	 
	  $Menu->menu_icon = $short_imageTarget;
	  $Menu->save();	 
	  return redirect()->route('provider-menu.index')->with('success',trans('Saved successfully'));
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
      ProvidersMenus::whereIn('id',$ids)->delete();
      return redirect()->route('provider-menu.index')->with('message',trans('Deleted Successfully.'));
	}

	public function update_status(Request $request)
	{
	  $id=$_GET['id'];
      $status=$_GET['value'];
      $model = ProvidersMenus::find($id);
      if($model) 
      {
        $model->status = $status;
        $model->save();
      }
	}
}
