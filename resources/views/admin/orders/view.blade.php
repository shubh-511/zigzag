@extends('layouts.adminlay')
 
@section('content')
 
<aside class="right-side">                
                <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Order number #: {{$order->order_number}}
    
    @if($order->order_status==1)
    <i class="fa fa-plus" aria-hidden="true"  title="New order"></i>
    @elseif($order->order_status==2)
    <i class="fa fa-check" aria-hidden="true"  title="Accepted by driver"></i>
    @elseif($order->order_status==3)
    <i class="fa fa-truck" aria-hidden="true"  title="Out for delivery"></i>
    @elseif($order->order_status==4)
    <i class="fa fa-check-circle" aria-hidden="true"  title="Delivered"></i>
    @elseif($order->order_status==5)
    <i class="fa fa-window-close" aria-hidden="true" title="Order cancelled"></i>
    @elseif($order->order_status==6)
    <i class="fa fa-undo" aria-hidden="true"  title="Refunded"></i>
    @endif
    
    </h1><span class="total-left">Rating: @if(!empty($rating))@for($i=1;$i<=round($rating,0);$i++) <img src="{{asset('public/assets/star.png')}}" height="25" title="{{$i}}"> @endfor @else {{'No review found yet'}} @endif</span>
    
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a>
      </li>
      <li><a href="{{ url('admin/orders')}}">Orders</a>
      </li>
      <li class="active">View order</li>
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
    
    @if($order->order_status >= 2)
        <div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Order ID</label>
				<label for="exampleInputEmail" class="form-control" class="form-control">{{$order->id}}</label>
            </div>
			<div class="form-group">
				<label for="exampleInputEmail">Order number</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->order_number}}</label>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail">Client name</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->user->name}}</label>
			</div>
		</div>
		<div class="col-md-6">
		    <label for="exampleInputEmail">Assign driver image</label>
			<div class="form-group">
			    
			     <img src="{{asset($order->driver->user_image ?? '')}}" height="185" width="180" style="margin-top:25px">
			     <a href="{{asset($order->driver->user_image ?? '')}}" download title="Download"><i class="fa fa-download" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
			     <a style="margin-left: 12px;" href="{{url('admin/drivers/driver-profile',[$order->assign_driver_id])}}" title="View profile"><i class="fa fa-user" style="font-size: 30px;color: green;" aria-hidden="true"></i></a>
			</div>
		</div>
	@else
	
	<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Order ID</label>
				<label for="exampleInputEmail" class="form-control" class="form-control">{{$order->id}}</label>
            </div>
            </div>
            <div class="col-md-6">
			<div class="form-group">
				<label for="exampleInputEmail">Order number</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->order_number}}</label>
			</div>
			</div>
			<div class="col-md-6">
			<div class="form-group">
				<label for="exampleInputEmail">Client name</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->user->name}}</label>
			</div>
		</div>
	@endif	
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Provider name</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->provider->name}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Ordered date</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($order->created_at))}}</label>
			</div>
		</div>
	    <div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Order amount</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->amount}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Delivery charge</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->delivery_charge}}</label>
			</div>
		</div>
	<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Final order amount(Delivery charge + Order amount)</label>
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->final_order_amount}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Billing email</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->billing_email}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Billing address</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->billing_address}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Billing city</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->billing_city}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Billing state</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->billing_state}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Billing country</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->billing_country}}</label>
			</div>
		</div>
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Billing zipcode</label>		
                
                <label for="exampleInputEmail" class="form-control" class="form-control">{{$order->billing_zipcode}}</label>
			</div>
		</div>
		
		<div class="col-md-12">
		    <h3>Order logs:</h3>
		    </div>
		
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Order placed at:</label>		
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($order->created_at))}}</label>
			</div>
		</div>
		<div class="col-md-6"> </div>
		@if($order->order_status <= 2)
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Driver accepted at:</label>		
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($order->accepted_date))}}</label>
			</div>
		</div>
		@endif
		@if($order->order_status <= 3)
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Out for delivery at:</label>		
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($order->out_for_delivery_date))}}</label>
			</div>
		</div>
		@endif
		@if($order->order_status <= 4)
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Delivered at:</label>		
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($order->delivered_at))}}</label>
			</div>
		</div>
		@endif
		@if($order->order_status <= 5)
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Cancelled at:</label>		
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($order->canceled_at))}}</label>
			</div>
		</div>
		@endif
		@if($order->order_status <= 6)
		<div class="col-md-6">            
            <div class="form-group">
				<label for="exampleInputEmail">Refunded at:</label>		
                <label for="exampleInputEmail" class="form-control" class="form-control">{{ date("jS M, Y",strtotime($order->refunded_at))}}</label>
			</div>
		</div>
		@endif

            
        
                                    
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
   