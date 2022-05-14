@extends('layouts.adminlay')
 
@section('content')
 
<aside class="right-side">                
                <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Profile #: {{$user->name}} @if($user->admin_approval=='0')
    <i class="fa fa-stop" aria-hidden="true" style="color:red" title="Under Inspection"></i>
    @else
    <i class="fa fa-stop" aria-hidden="true" style="color:green" title="Verified By Zig-Zag"></i>
    @endif</h1><span class="total-left">Rating: @if(!empty($rating))@for($i=1;$i<=round($rating,0);$i++) <img src="{{asset('public/assets/star.png')}}" height="25" title="{{$i}}"> @endfor @else {{'No review found yet'}} @endif</span>
    
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
      </li>
      <li><a href="{{ url('admin/drivers')}}">Drivers</a>
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
				<label for="exampleInputEmail">Driver Name</label>
				<label for="exampleInputEmail" class="form-control" class="form-control">{{$user->name}}</label>
            </div>
			<div class="form-group">
				<label for="exampleInputEmail">Last Name</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->last_name}}</label>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail">Email</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->email}}</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			     <img src="{{asset($user->user_image)}}" height="185" width="180" style="margin-top:25px">
			     <a href="{{asset($user->user_image)}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
			</div>
		</div>
		<div class="col-md-2">            
            <div class="form-group">
				<label for="exampleInputEmail">Country code</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->country_code}}</label>
			</div>
		</div>
		<div class="col-md-4">            
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
	  <!--  <div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Address</label>		
                
                <textarea readonly="true" class="form-control" class="form-control" style="height:105px">{{$user->address}}</textarea>
			</div>
		</div>-->
	<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Country</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->country->name??'NA'}}</label>
			</div>
		</div>
		
		<!--<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">State</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->state->name ?? ''}}</label>
			</div>
		</div>-->
		
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">City</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->city_id??'NA'}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Language Known</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->language_known ?? 'NA'}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">About(Describe Yourself)</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->describe_yourself??'NA'}}</label>
			</div>
		</div>
			<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Home Town</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->homeaddress?? 'NA'}}</label>
			</div>
		</div>
	@if(Session::get('bu_user_info')->roles_id!='3')@endif        
		
	 	<!--<div class="col-md-3">
	        <div class="form-group">
      			<label for="exampleInputEmail">Driver Tax number</label>
  				<label for="exampleInputEmail" class="form-control" class="form-control" >{{$user->tax_number}}</label>
            </div>
        </div>
        <div class="col-md-3">
	        <div class="form-group">
      			<label for="exampleInputEmail">Profit Ratio (%)</label>
  				<label for="exampleInputEmail" class="form-control" class="form-control" >{{$user->profit_ratio}}</label>
            </div>
        </div>-->
		<div class="col-md-12">            
            <div class="form-group">
				<label for="exampleInputEmail">Status</label>
                <label for="exampleInputEmail" class="form-control" class="form-control" @if($user->status=='0') style="background-color:orange; color:white" @else style="background-color:#3CB371;color:white" @endif >@if($user->status==1) {{'Active'}} @else {{'Inactive'}} @endif</label>
			</div>
		</div>
			
		

		<div class="col-md-12">            
            <div class="form-group">
				<label for="exampleInputEmail">Inspection</label>
                <label for="exampleInputEmail" class="form-control" class="form-control" @if($user->admin_approval=='0') style="background-color:orange; color:white" @else style="background-color:#3CB371; color:white" @endif>@if($user->admin_approval==1) {{'Verified Account'}} @else {{'Under Inspection'}} @endif</label>
			</div>
		</div>
		
		<!--<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Social Security Number / Adhar Number</label>
                <label for="exampleInputEmail" class="form-control" class="form-control" >{{$user->user_documents[0]->adhar_number ?? ''}}</label>
			</div>
		</div>-->

       <div class="col-md-12">
	   
		<div class="col-md-4">
            <div class="form-group">
		     <label for="exampleInputEmail">Driver's License Image</label><br>
		        @if(!empty($user->user_documents[0]))
		        @if(null!==$user->user_documents[0]->dl_image)
		        <img src="{{asset($user->user_documents[0]->dl_image ?? '')}}" height="135px">
		        <a href="{{asset($user->user_documents[0]->dl_image ?? '')}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
		        @endif
		        @endif
		     </div>
        </div>
		<div class="col-md-4" >
            <div class="form-group">
		     <label for="exampleInputEmail">Car Insurance Image</label><br>
		           @if(!empty($user->user_documents[0]))
		             @if(null!==$user->user_documents[0]->insurance_image)
		           <img src="{{asset($user->user_documents[0]->insurance_image ?? '')}}" height="135px"> 
		           <a href="{{asset($user->user_documents[0]->insurance_image)}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
		          @endif
		          @endif
		     </div>
           </div>
		   <div class="col-md-4" >
                <div class="form-group">
    		     <label for="exampleInputEmail">Registartion Image</label><br>
    		           @if(!empty($user->user_documents[0]))
    		             @if(null!==$user->user_documents[0]->registration_img)
    		           <img src="{{asset($user->user_documents[0]->registration_img ?? '')}}" height="135px"> 
    		           <a href="{{asset($user->user_documents[0]->registration_img)}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
    		           @endif
    		          @endif
    		     </div>
            </div>
       <!-- <div class="col-md-4">            
            <div class="form-group">
				<label for="exampleInputEmail">Driver's License Number</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->dl_number ?? ''}}</label>
			</div>
		</div>
		<div class="col-md-4">            
            <div class="form-group">
				<label for="exampleInputEmail">Driver's License Expiry Date</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->dl_expiry_date ?? ''}}</label>
			</div>
		</div>-->
		</div>
		<div class="col-md-12">
        <?php /* <div class="col-md-4">
            <div class="form-group">
		     <label for="exampleInputEmail">Driver's Pancard Image</label><br>
		        @if(!empty($user->user_documents[0]))
		        <img src="{{asset($user->user_documents[0]->pancard_image ?? '')}}" height="135px">
		        <a href="{{asset($user->user_documents[0]->pancard_image ?? '')}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
		        @endif
		     </div>
        </div>*/ ?>
		 <div class="col-md-4">
            <div class="form-group">
		     <label for="exampleInputEmail">vehicle Permit Image</label><br>
		      @if(!empty($user->user_documents[0]))
		        @if(null!=$user->user_documents[0]->permit_image)
		        <img src="{{asset($user->user_documents[0]->permit_image ?? '')}}" height="135px">
		        <a href="{{asset($user->user_documents[0]->permit_image ?? '')}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
		        @endif
		         @endif
		     </div>
        </div>
        <div class="col-md-4">
        <div class="form-group">
		     <label for="exampleInputEmail">Criminal Record Image</label><br>
		        @if(!empty($user->user_documents[0]))
		          @if(null!=$user->user_documents[0]->criminal_record_img)
		        <img src="{{asset($user->user_documents[0]->criminal_record_img ?? '')}}" height="135px">
		        <a href="{{asset($user->user_documents[0]->criminal_record_img ?? '')}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
		        @endif
		        @endif
		     </div>
        </div>
        <div class="col-md-4">
        <div class="form-group">
		     <label for="exampleInputEmail">Police Record Image</label><br>
		        @if(!empty($user->user_documents[0]))
		            @if(null!=$user->user_documents[0]->police_record_img)
		        <img src="{{asset($user->user_documents[0]->police_record_img ?? '')}}" height="135px">
		        <a href="{{asset($user->user_documents[0]->police_record_img ?? '')}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
		        @endif
		        @endif
		     </div>
        </div>
           <!--<div class="col-md-4">            
            <div class="form-group">
    				<label for="exampleInputEmail">Car Insurance Number</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->insurance_number ?? ''}}</label>
    			</div>
    		</div>
    		<div class="col-md-4">            
                <div class="form-group">
    				<label for="exampleInputEmail">Car Insurance Expiry Date</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->insurance_expiry_date ?? ''}}</label>
    			</div>
    		</div>-->
        </div>
        <div class="col-md-12">
            <div class="col-md-3">            
            <div class="form-group">
    				<label for="exampleInputEmail">Car Number</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->car_number ?? ''}}</label>
    			</div>
    		</div>
    		<div class="col-md-3">            
                <div class="form-group">
    				<label for="exampleInputEmail">Model Number</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->model_number ?? ''}}</label>
    			</div>
    		</div>
    		<div class="col-md-3">            
            <div class="form-group">
    				<label for="exampleInputEmail">Car Name</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->car_name ?? ''}}</label>
    			</div>
    		</div>
    		<div class="col-md-3">            
                <div class="form-group">
    				<label for="exampleInputEmail">Car Color</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->car_color ?? ''}}</label>
    			</div>
    		</div>
            
          <!--  <div class="col-md-4">            
            <div class="form-group">
    				<label for="exampleInputEmail">Registartion Number</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->registration_number ?? ''}}</label>
    			</div>
    		</div>
    		<div class="col-md-4">            
                <div class="form-group">
    				<label for="exampleInputEmail">Registartion Expiry Date</label>
                    <label for="exampleInputEmail" class="form-control" class="form-control">{{$user->user_documents[0]->registration_expiry_date ?? ''}}</label>
    			</div>
    		</div>-->
    		
    		
    		
        </div>
        <?php /*<div class="col-md-6" style="visibility:hidden">            
          <div class="form-group">
            <input type="file" class="form-control"  name="legal_doc1">
          </div> 
        </div>
        
       
        
        <div class="col-md-6" style="visibility:hidden">
            <div class="form-group">
  			<input type="file" class="form-control"  name="legal_doc2">
            </div>
        </div>*/ ?>
        
                                    
</div><!-- /.box-body -->
</form>
<div class="clearfix"></div>
  </div><!-- /.box -->
 </div>
 </div>

@stop

@section('eon_js')
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
@endsection
   