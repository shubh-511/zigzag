@extends('layouts.adminlay')
@section('content')
<aside class="right-side">                
                <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Delivery Charges List
            ({{ count($delivery)}})
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('backend/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Delivery Charges</li>
        </ol>
    </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                                                      
                            <div class="box">
                                <div class="box-header">

    @if(Session::has('success_message')) 
    <div class=" alert alert-success"> 
   		<span class="glyphicon glyphicon-ok "></span>
   		<em> {!! session('success_message') !!}</em>
	</div>
	@endif
	@if(Session::has('error_message')) 
    <div class=" alert alert-dengar"> 
   		<span class="glyphicon glyphicon-remove "></span>
   		<em> {!! session('error_message') !!}</em>
	</div>
	@endif
	
    <form name="form2" id="form2" method="get" action=""   class="form-horizontal">
          <table class="table table-advance" >
      <tr>
       <!-- <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
          <th><input type="text" placeholder="Enter Email" name="email" value=""></th>
      <th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
            <th><input type="hidden" name="search" value="search">
            <button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
            </th>
            -->
            <th><span style="float: right;">
              <a href="{{ url('admin/add-new-charge')}}" class="btn btn-default"> Add Delivery Charge</a>
              <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
            </th>
    </tr>
      </table>
    </form>
</div><!-- /.box-header -->
	
    <form id="service" name="service" action="" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
        
        <thead>
            <tr>
                <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>
				<th>Title</th>
                
                <th>Charges ($)</th>
				<th>Status</th>
                <th>Action</th>
            </tr>
        </thead>      
								 
						  	 
            <tbody id="rowbody">
        @foreach($delivery as $service)
            <tr>
                <th scope="col"><input type="checkbox" name="mul_del[]"  value="{{ $service->id }}" />
                </th>

				<td>{{ $service->title }}</td>
				
				<td>$ &nbsp{{ $service->charges }}</td>
				<td>
         
        			<a href="javascript:" onclick="update_status('{{ $service->id}}',{{abs($service->status-1)}})">
                    <span class="label  @if($service->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                        @if($service->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                    </span>
            		</a>
       			</td>


       			 
												
				<td>
    				<a title="Edit" href="{!! url('admin/delivery-charge/edit-charge',[$service->id]) !!}"><i class="fa fa-pencil"></i>
    				</a> 
    			</td>
                                            </tr>
                @endforeach
                    </tbody> 
        
						  			 
                                        
                                    </table>
        {{ $delivery->links()}}                              
                                </div><!-- /.box-body -->
								</form>
                            </div><!-- /.box -->
                        </div>
                    </div>
             

@stop

<script language="JavaScript">
	
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
	
function muldelete()
	{
		element_lenght= service.elements.length;
		for(i=0;i<element_lenght;i++)
		{
			if(service.elements[i].name=="mul_del[]")
			{
				if(service.elements[i].checked==true)
				{
					
					if(confirm("Are you sure delete record(s)?"))
					{
						$("#service").attr("action", "{{url('admin/deletealldeliveryc')}}");				
					this.service.submit();
					break;
					}
				}	
			}
		}
	}
function update_status(id,value)
 	{     
    	$.ajax({
    	type: 'GET',
    	data: {'id':id,'value':value},
   	 	url: "../admin/updatedeliverycstatus",
    	success: function(result){
    	alert( 'Update Action Completed.');
   		location.reload();
    	}});
	}	

</script>