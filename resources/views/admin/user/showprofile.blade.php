@extends('layouts.adminlay')
 
@section('content')
 
<aside class="right-side">                
                <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Profile #: {{$user->name}}</h1>
     <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
      </li>
      <li><a href="{{ url('admin/user')}}">Users</a>
      </li>
      <li class="active">Show Profile</li>
    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="row">
<div class="col-xs-12">
 <div class="box">
    <div class="box-header" >
    <!-- @if(Session::has('message')) <div class=" alert alert-success"> 
   <span class="glyphicon glyphicon-ok "></span><em> {!! session('message') !!}</em>
</div>@endif 
-->

 <!--   
<form name="form2" id="form2" method="get" action=""   class="form-horizontal">
          <table class="table table-advance" >
      <tr>
        <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
          <th><input type="text" placeholder="Enter Email" name="email" value=""></th>
      <th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
            <th><input type="hidden" name="search" value="search">
            <button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
            </th>
            <th><span style="float: right;">
              <a href="{{url('admin/useradd')}}" class="btn btn-default"> Add User</a>
              <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
            </th>
    </tr>
      </table>
    </form>-->
</div><!-- /.box-header -->

<form id="user" name="user" action="" method="post">
    <div class="box-body table-responsive">
    
        <div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Agent Name</label>
				<label for="exampleInputEmail" class="form-control" class="form-control">{{$user->name}}</label>
            </div>
		
			<div class="form-group">
				<label for="exampleInputEmail">Email</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->email}}</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			     <img src="{{asset($user->user_image)}}" height="185" width="180" style="margin-top:25px">
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Mobile</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->mobile}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Reg. Date</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($user->created_at))}}</label>
			</div>
		</div>
	    <div class="col-md-12">            
            <div class="form-group">
				<label for="exampleInputEmail">Address</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->address}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">State</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">@if(!empty($city)){{$state->name}}@else {{'State not found'}}@endif</label>
			</div>
		</div>
		
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Status</label>
                <label for="exampleInputEmail" class="form-control" class="form-control" @if($user->status=='0') style="background-color:orange; color:white" @else style="background-color:#3CB371;color:white" @endif >@if($user->status==1) {{'Active'}} @else {{'Inactive'}} @endif</label>
			</div>
		</div>
		
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">City</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">@if(!empty($city)){{$city->name}}@else {{'City not found'}} @endif</label>
			</div>
		</div>
		
		<!--<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Email Verification</label>
                <label for="exampleInputEmail" class="form-control" class="form-control" @if($user->email_verify=='0') style="background-color:orange; color:white" @else style="background-color:#3CB371;color:white" @endif>@if($user->email_verify==1) {{'Verified'}} @else {{'Pending'}} @endif</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Role</label>
                <label for="exampleInputEmail" class="form-control" class="form-control" >{{$user->roles->name}}</label>
			</div>
		</div>-->
		
	<?php /*	<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Business Name</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->business_name}}</label>
			</div>
		</div>
		*/?>
		
	@if($user->roles_id==5)	
	<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Document Inspection</label>
                <label for="exampleInputEmail" class="form-control" class="form-control" @if($user->verify=='0') style="background-color:orange; color:white" @else style="background-color:#3CB371; color:white" @endif>@if($user->verify==1) {{'Verified'}} @else {{'Pending'}} @endif</label>
			</div>
		</div>
    <div class="col-md-12">   
    <table id="example1" class="table table-bordered table-striped">
        
      
      <tr>
        <th colspan="2" style="padding-left:280px;" >Documents</th>
        
      </tr>
      
   
        
        <tr>
        <td>
            <div class="col-md-3">
            <div class="row">
                <div class="col-md-9">
                    
                <img src="{{asset('assets/images/no-image-available.png')}}" height="100" width="100">
                 </div>
            <div class="col-md-3">
                <p style="margin-top:35px;"><a href="{{ url('admin/user/upload_document',[$user->id])}}" title="Edit/Upload Social Security Card" style="font-size:20px;"><i class="fa fa-upload" aria-hidden="true"></i></a> </p>
                
                </div>
            </div>
            </div>
            </td>
       
      </tr>
      
    
   
       
        
           </table>
           </div>
           @endif
          
   <div class="box-footer" style="float:right">
       <a href="{{ url('admin/user')}}" class="btn btn-primary">Back</a>
       <!--<a href="{{ url('admin/user/useredit',[$user->id])}}" class="btn btn-primary">Edit</a>-->
     </div>
                                    
</div><!-- /.box-body -->
</form>
<div class="clearfix"></div>
  </div><!-- /.box -->
 </div>
 </div>

@stop

 <script type="text/javascript">
function isValid(formRef)
    {

        for(var i=0;i<formRef.elements.length;i++)
        {
            if(formRef.elements[i].type == "checkbox")
            {
                formRef.elements[i].checked = formRef.cb1.checked
            }
        }//end of loop
    }


 function update_dl_status(id,value)
 {     
    $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../../update_dl_status",
    success: function(result){
    alert( 'Update Action Completed.');
   location.reload();
    
    }});
 }
 function update_ssc_status(id,value)
 {     
    $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../../update_ssc_status",
    success: function(result){
    alert( 'Update Action Completed.');
   location.reload();
    
    }});
 }
 function update_insurance_status(id,value)
 {     
    $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../../update_insurance_status",
    success: function(result){
    alert( 'Update Action Completed.');
   location.reload();
    
    }});
 }
 function update_pcc_status(id,value)
 {     
    $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../../update_pcc_status",
    success: function(result){
    alert( 'Update Action Completed.');
   location.reload();
    
    }});
 }
 
 
 function inspect(id,value)
 {     
     
    $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../admin/inspection",
    success: function(result){
    alert( 'Update Action Completed.');
   location.reload();
    
    }});
 }
 
function muldelete()
    {
        element_lenght= user.elements.length;
        for(i=0;i<element_lenght;i++)
        {
            if(user.elements[i].name=="mul_del[]")
            {
                if(user.elements[i].checked==true)
                {
                    if(confirm("Are you sure delete record(s)?"))
                    {
                        $("#user").attr("action", "{{url('admin/deletealluser')}}");
                        this.user.submit();
                        break;
                    }
                }   
            }
        }
    }
 

      
</script>
   