@extends('layouts.adminlay')
@section('content')

@push('multi_select')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
@endpush
<aside class="right-side">
   <section class="content-header">
      <h1>Edit Profile</h1>
        <ol class="breadcrumb">
          <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
           
          <li class="active">My Profile</li>
        </ol> 
    </section>
    <section class="content">
       <div class="row">
        <div class="col-md-12">
           <div class="box box-primary">
                <div class="box-header"> 
                    
                    <!--success_message-->
                @if(Session::has('error_message'))         
            <div class="alert alert-danger">
              {!! session('error_message') !!}
            </div>
             @endif 
                @if(Session::has('success_message')) 
                    <div class=" alert alert-success"> 
                      <span class="glyphicon glyphicon-ok "></span><em> {!! Session::get('success_message') !!}</em>
                    </div>
                @endif 
                                    
                   </div><!-- /.box-header -->
                 <form role="form" action="{!! url('admin/saveprofile',[$profile->id]) !!}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                <div class="col-md-6">            
                <div class="form-group">
					<label for="exampleInputEmail">Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{$profile->name}}" >
				</div>
				</div>
                
                <div class="col-md-6">
    			<div class="form-group">
    				<label for="exampleInputEmail">Email</label>
					<input type="text" class="form-control" id="email" name="email"  required value="{{ $profile->email }}">
    			</div>
    			</div>
                <div class="col-md-6">
    			<div class="form-group">
      				<label for="exampleInputEmail">Password</label>
      				<input id="password-field" type="password" class="form-control" name="password" value="{{$profile->txtpassword}}">
              <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
					<?php /*<input type="password" class="form-control" id="password" name="password"  required value="{{$profile->txtpassword}}" id="password-field">
					<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>*/
					?>
    			</div>
    			</div>
    			
    			 
                <div class="col-md-6">
    			<div class="form-group">
      				<label for="exampleInputEmail">Mobile</label>
					<input type="text" class="form-control" id="mobile" name="mobile"  required value="{{ $profile->mobile}}">
    			</div>
    			</div>
   
   		<?php 	/*		
   				<div class="form-group">
    				<label for="status">Role</label>
        			<select class="form-control" name="role_id" required>
					@foreach($roles as $role)                         
           			<option value="{{$role->id}}" @if(old('role_id') == $role->id) selected @endif >{{$role->name}}</option>
        			@endforeach
        			</select> 
				</div>
				*/
		?>

		@if(Auth::user()->roles_id==3)

		<div class="col-md-6">
                  <div class="form-group">
                     <label>Address</label>
                     <input type="text" name="address" class="form-control" value="{{$profile->address}}">
                  </div>
               </div>

		<div class="col-md-6">
                  <div class="form-group">
						<label for="Parent customer">Delivery/No Delivery </label>
						<select class="form-control" name="product_cat_id" required>
						  <option value='1' @php if($profile->delivery_available==1){ echo 'active'; } @endphp>Delivery</option>
						  <option value='0' @php if($profile->delivery_available==0){ echo 'active'; } @endphp>No Delivery</option> 
						</select> 
                  </div>
               </div>
			   <div class="col-md-6">
                  <div class="form-group">
						<label for="Parent customer">Active/Inactive </label>
						<select class="form-control" name="status" required>
						<option value='1' @php if($profile->status==1){ echo 'active'; } @endphp >Active</option>
						<option value='0'@php if($profile->status==0){ echo 'active'; } @endphp>Inactive</option> 
						</select> 
                  </div>
               </div>

			   <div class="col-md-6">
                  <div class="form-group">
				        @php 
						  $categoryArr = array();
						  $category_ids = $profile->category_ids; 
						  if(!empty($category_ids)){
						    $categoryArr = explode(',',$category_ids);
						  }
						@endphp
						<label for="Parent customer">Select Category</label>
						<select data-placeholder="Begin typing a name to filter..." multiple class="chosen-select form-control" name="category_id[]" multiple required>
						  @if(!empty($category))
						  @foreach($category as $cat)
						  <option value="{{ $cat->id }}" @php if(!empty($categoryArr) && in_array($cat->id,$categoryArr)){ echo 'selected'; } @endphp >{{ $cat->name }}</option>
						  @endforeach
						  @endif
						</select> 
                  </div>
               </div>
               
               <div class="col-md-6">
                  <div class="form-group">
                     <label>Description</label>
                     <textarea name="description" class="form-control" >{{$profile->description}}</textarea>
                  </div>
               </div>



		@endif


		    <div class="col-md-6">
				<div class="form-group">
      				<label for="exampleInputEmail">Profile Image</label>
					<input type="file" class="form-control" id="image" name="image">
    			</div>
    			<img src="{!! asset($profile->user_image)!!}" height="80" width="80">
            </div>
            
             
    	 
    	    
    	    
    	    
        </div><!-- /.box-body -->

                <div class="col-md-12">
                    <div class="box-footer" style="float:right">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>  
        <div class="form-group">
            </div>
        </div><!-- /.box -->

        <!-- Form Element sizes -->
    </div>
</div>
</div>
@stop


@push('footer_multiple')
<script>
        $(".chosen-select").chosen({
          no_results_text: "Oops, nothing found!"
        })
        </script>
@endpush
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
     $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($('.toggle-password').attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

 }); 
 // fa-eye-slash
</script>