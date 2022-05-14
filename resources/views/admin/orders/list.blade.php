@extends('layouts.adminlay')
 
@section('content')
 
<aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Orders   </h1>
                    
                    <span>Current Page: {{count($orders) ?? ''}}</span><br>
                    <span>Total: {{$orders->total() ?? ''}}</span>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Orders</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<div class="row">
<div class="col-xs-12">
 <div class="box">
    <div class="box-header" >
     @if(Session::has('message')) <div class=" alert alert-success"> 
   <span class="glyphicon glyphicon-ok "></span><em> {!! session('message') !!}</em>
</div>@endif 

    
<form name="form2" id="form2" method="get" action=""   class="form-horizontal">
          <table class="table table-advance" >
      <tr><th >
          <input style="width:50%;" type="text" id="txt_search" placeholder="Search by order id or order number#" class="form-control" autofill="off" name="txt_search" ></th>
      <!--  <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
          <th><input type="text" placeholder="Enter Email" name="email" value=""></th>
      <th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
            <th><input type="hidden" name="search" value="search">
            <button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
            </th>
        -->
           <th><span style="float: right;">
             <!--  <a href="{{url('admin/useradd')}}" class="btn btn-default"> Add User</a>
              <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>-->
            </th>
    </tr>
    
      </table>
    </form>
</div><!-- /.box-header -->

<form id="user" name="user" action="" method="post">
    <div class="box-body table-responsive">

    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                 <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>
                <th>Order Number#</th>
                <th>Client Name</th>
                <th>Service Provider</th>
                <th>Order Amount</th>
                <th>Delivery Charge</th>
                <th>Payment Status</th>
                <th>Order Status</th>
               <th colspan="2">Action</th>
                
            </tr>
        </thead>

        <tbody id="rowbody">
        	@foreach($orders as $user)
            <tr>
            <th scope="col">
            <input type="checkbox" name="mul_del[]" id="mul_del[]" value="{{$user->id}}" /></th>
            <td>{{$user->order_number}}</td>																            
            <td>{{$user->user->name}}</td>
            <td>{{$user->provider->name}}</td>
            <td>{{$user->final_order_amount}}</td>
            <td>{{$user->delivery_charge}}</td>
            <td>@if($user->status == 1) <span class="label label-success"> {{'Success'}} </span> @else <span class="label label-warning"> {{'Failed'}} </span> @endif</td>
            <td>@if($user->order_status==1){{'Order placed'}} @elseif($user->order_status==2) {{'Accepted by driver'}} @elseif($user->order_status==3) {{'Out for delivery'}} @elseif($user->order_status==4) {{'Order delivered'}} @elseif($user->order_status==5) {{'Order Calcelled'}} @elseif($user->order_status==6) {{'Refunded'}} @else {{'--'}} @endif</td>
            
            <td>
                <a href="{{ url('admin/orders/view-order',[$user->id])}}"><i title="View Order" class="fa fa-desktop"></i></a>
            </td>
            
            </tr>
            @endforeach
        </tbody>         
           </table>
            {{$orders->links()}}
   
</div><!-- /.box-body -->
</form>
  </div><!-- /.box -->
 </div>
 </div>
@push('footer_scrpt')
       <script type="text/javascript">
    
/*
|************************************************************************
|                 User Search
|************************************************************************
*/
        $(document).ready(function(){

            $("#txt_search").keyup(function(){
                
               var search = $(this).val();
                 
               //alert(roles); die;
                //if(search != ""){

                    $.ajax({
                        url: 'search_orders',
                        type: 'get',
                        data: {search:search},
                        //dataType: 'json',
                        success:function(response){
                          //alert(response);
                            $('#rowbody').html(response);
                            //$('#rowbody').append('<option value="">Select country first</option>');
                         }
                    });
                // }
                // else
                // {
                //     $("#searchResult").empty();
                //     $("#state_id").val('');
                // }

            });
           
            
        });
 </script> 
@endpush  
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


 function update_status(id,value)
 {     
    $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../admin/updatedriversstatus",
    success: function(result){
    alert( 'Update Action Completed.');
   location.reload();
    
    }});
 }
 function update_account_status(id,value)
 {     
     
    $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../admin/updateDriverInspection",
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
                        $("#user").attr("action", "{{url('admin/deletealldriver')}}");
                        this.user.submit();
                        break;
                    }
                }   
            }
        }
    }
 

      
</script>