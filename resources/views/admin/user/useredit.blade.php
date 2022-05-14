@extends('layouts.adminlay')
@section('content')
<?php //echo '<pre>';print_r($roles);?>
<aside class="right-side">
    <section class="content-header">
      <h1>Edit User</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/user')}}">User</a></li>
        <li class="active">Edit User</li>
      </ol> 
    </section>
    
    <section class="content">
       <div class="row">
        <div class="col-md-12">
           <div class="box box-primary">
                <div class="box-header"> 
                     @foreach ($errors->all() as $error)
                          <div class=" alert alert-danger">
                             <span class="glyphicon glyphicon-remove"></span>{{ $error }}
                           </div>
                     @endforeach
                        
        
            <form role="form" action="{{ url('admin/edituser',$user->id)}}" method="post" enctype="multipart/form-data">
                
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                <div class="col-md-6">            
                <div class="form-group">
					<label for="exampleInputEmail">Name</label>
                    <input type="text" class="form-control"  name="name" required value="{{ $user->name }}">
				</div>
			 
			 
				<div class="form-group">
      				<label for="exampleInputEmail">Email</label>
                    <input readonly type="text" class="form-control"  name="email"  required value="{{ $user->email }}">
                </div>
                </div>
                
                <div class="col-md-6">
    			<div class="form-group">
    			     <img src="{{asset($user->user_image)}}" height="150" width="180" style="margin-top:25px;    width: auto;">
    			     <input type="file" class="form-control"  name="user_image">
    			</div>
    		    </div>
    		    
    		  
                
    		    
    		    <div class="col-md-6">
		        <div class="form-group">
      				<label for="exampleInputEmail">Mobile</label>
                    <input type="text" class="form-control"   name="mobile"  required value="{{ $user->mobile }}">
                </div>
                </div>
                
                {{--<div class="col-md-6">
		        <div class="form-group">
      				<label for="exampleInputEmail">Role</label>
      				<select class="form-control" name="roles_id">
      				    @foreach($roles as $role)
      				        <option value="{{$role->id}}" @if($role->id==$user->roles_id) selected="true" @endif>{{$role->name}}</option>
      				    @endforeach
      				     
      				</select> 
                </div>
                </div>--}}
                
                <!--<div class="col-md-12">
		        <div class="form-group">
      			  <label for="exampleInputEmail">Address</label>
                  <input type="text" class="form-control"  id="address" name="address" value="{{ $user->address }}" required> 
                  <input type="hidden" name="longitude" id="longitude" value="{{$user->longitude}}">
                  <input type="hidden" name="latitude" id="latitude" value="{{$user->latitude}}">
                </div>
                </div>-->
                
                {{--<div class="col-md-6">
		        <div class="form-group">
      				<label for="exampleInputEmail">State</label>
      				<select class="form-control" id="state_id" name="state_id">
      				    <option value="" disabled>--Select State--</option>
      				    @foreach($states as $state)
      				    <option value="{{$state->id}}" @if($user->state_id==$state->id) selected="true" @endif>{{$state->name}}</option>
      				    @endforeach
      				</select>
                </div>--}}
                </div>
                
                <div class="col-md-6">
		        <div class="form-group">
          				<label for="exampleInputEmail">Status</label>
      				<select class="form-control" name="status"  >
      				    <option value="1" @if($user->status==1) selected="true" @endif>Active</option>
      				    <option value="0" @if($user->status==0) selected="true" @endif>Inactive</option>
      				</select> 
                </div>
                </div>
                
               {{-- <div class="col-md-6">
		        <div class="form-group">
      				<label for="exampleInputEmail">City</label>
      				<select class="form-control" id="city_id" name="city_id">
      				    <option value="" disabled>--Select City--</option>
      				    @foreach($cities as $city)
      				    <option value="{{$city->id}}" @if($user->city_id==$city->id) selected="true" @endif>{{$city->name}}</option>
      				    @endforeach
      				    
      				</select>
                </div>
                </div>--}}
                
                
                <div class="col-md-6">
		        {{--<div class="form-group">
      				<label for="exampleInputEmail">Email Verification</label>
      				<select class="form-control" name="email_verify" @if($user->email_verify=='0') style="background-color:orange; color:white" @else style="background-color:#3CB371;color:white" @endif>
      				    <option value="1" @if($user->email_verify==1) selected="true" @endif>Verified</option>
      				    <option value="0" @if($user->email_verify==0) selected="true" @endif>Pending</option>
      				</select> 
                </div>--}}
                </div>
                
                 @if($user->roles_id==5)
               <div class="col-md-6">
		        <div class="form-group">
      			<?php /* 	<label for="exampleInputEmail">Business Name</label>*/ ?>
                    <input type="hidden" class="form-control" name="business_name"  value="{{ $user->business_name }}">
                </div>
                </div>
                
                
                <div class="col-md-6">
		        <div class="form-group">
      				<label for="exampleInputEmail">Documents Inspection</label>
      				<select class="form-control" name="verify" @if($user->verify=='0') style="background-color:orange; color:white" @else style="background-color:#3CB371; color:white" @endif>
      				    <option value="1" @if($user->verify==1) selected="true" @endif>Verified</option>
      				    <option value="0" @if($user->verify==0) selected="true" @endif>Pending</option>
      				</select> 
                </div>
                </div>
                @endif
                
                <div class="col-md-12">
                <div class="box-footer" style="float:right">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                </div>
                </div>
                
               </div>
            </form>
                    
                    <div class="clearfix"></div>
                    
                   </div><!-- /.box-header -->
         
            </div><!-- /.box -->
        </div>
     </div>
    @stop
    
 