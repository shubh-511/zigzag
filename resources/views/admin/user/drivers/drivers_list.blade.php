@extends('layouts.adminlay')
 
@section('content')
 
<aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Drivers   </h1>
                    
                    <span>Current Page: {{count($users) ?? ''}}</span><br>
                    <span>Total: {{$users->total() ?? ''}}</span>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Drivers</li>
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
          <input style="width:50%;" type="text" id="txt_search" placeholder="Search by name,email or mobile" class="form-control" autofill="off" name="txt_search" ></th>
      <!--  <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
          <th><input type="text" placeholder="Enter Email" name="email" value=""></th>
      <th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
            <th><input type="hidden" name="search" value="search">
            <button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
            </th>
        -->
           <th><span style="float: right;">
             <!--  <a href="{{url('admin/useradd')}}" class="btn btn-default"> Add User</a>-->
              <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
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
                <th>Driver Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Inspection</th>
                <th>Status</th>
               <th colspan="2">Action</th>
                
            </tr>
        </thead>

        <tbody id="rowbody">
        	@foreach($users as $user)
            <tr>
            <th scope="col">
            <input type="checkbox" name="mul_del[]" id="mul_del[]" value="{{$user->id}}" /></th>
            <td>{{$user->name}}</td>																            
            <td>{{$user->email}}</td>
            <td>{{$user->mobile}}</td>
            {{--<td>
                @if($user->roles->name=='business')
                <a href="javascript:" onclick="inspect('{{ $user->id}}',{{ abs($user->verify-1)}})">
                    <span class="label  @if($user->verify!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                        @if($user->verify=='1') {{'Verified'}} @else {{'Pending'}} @endif 
                    </span>
                </a>
                @endif
            </td>--}}
            <td>
                <?php //echo abs($user['status']-1);?>
                <a href="javascript:" onclick="update_account_status('{{ $user->id}}',{{ abs($user->admin_approval-1)}})">
                    <span class="label  @if($user->admin_approval!='0') {{'label-success'}} @else {{'label-strictwarning'}} @endif">
                        @if($user->admin_approval=='1') {{'Verified Account'}} @else {{'Pending'}} @endif 
                    </span>
            </a>
            </td>
            <td>
                <?php //echo abs($user['status']-1);?>
                <a href="javascript:" onclick="update_status('{{ $user->id}}',{{ abs($user->status-1)}})">
                    <span class="label  @if($user->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                        @if($user->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                    </span>
            </a>
            </td>
             
                <?php // {{url('user/destroy',[$user->id])}} ?>
                <!--<a title="Edit" href="{{url('admin/user/useredit',[$user->id])}}"><i class="fa fa-pencil"></i></a> -->
               
    <?php /*< <a title="Delete" href="#" onClick="deleteMe({{ $user->id}})"><i class="fa fa-trash-o"></i></a>
            */?>
            
            <td>
                <a href="{{ url('admin/drivers/driver-profile',[$user->id])}}"><i title="View Profile" class="fa fa-desktop"></i></a>
            </td>
            
            </tr>
            @endforeach
        </tbody>         
           </table>
            {{$users->links()}}
   
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
                        url: 'search_drivers',
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