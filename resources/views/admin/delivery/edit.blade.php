@extends('layouts.adminlay')
@section('content')
	<aside class="right-side">
                <!-- Content Header (blog header) -->
        <section class="content-header">
            <h1>
              Edit Delivery Charge
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{ url('admin/delivery-charge')}}">Delivery Charges</a></li>
                <li class="active">Edit Delivery Charge</li>
            </ol> 
        </section>
	
                <!-- Main content -->
                <section class="content">
<div class="row">

    <div class="col-md-12">
    <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
            <!-- <h3 class="box-title">Create Menu</h3>-->
            </div><!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="{{ url('admin/charge_edit',[$delivery->id])}}" method="post" enctype="multipart/form-data">
                <div class="box-body">

              
				<div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" required value="{{ $delivery->title}}">
                </div>
				<div class="form-group">
                <label for="exampleInputEmail1">Distance from(Miles)</label>
                <input type="text" class="form-control" id="from_distance" name="from_distance" placeholder="Distance from" required value="{{ $delivery->from_distance}}" >
                </div>
				<div class="form-group">
                <label for="exampleInputEmail1">Distance to(Miles)</label>
                <input type="number" class="form-control" value="{{ $delivery->to_distance}}" id="to_distance" name="to_distance" placeholder="Distance to" required>
                </div>
				<div class="form-group">
                <label for="exampleInputEmail1">Charge ($)</label>
                <input type="number" class="form-control" value="{{ $delivery->charges}}" id="charges" name="charges" placeholder="Charges" min="0" max="1000" step=".01"  required  >
                </div>
			  
     
	  

			    <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" required>
                <option value="0">--Select Status--</option>
                <option value='1' @if($delivery->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                <option value='0' @if($delivery->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
                </select> 
                </div>
			   
			   
                
              
                </div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

               
                </div><!-- /.box-body -->
    
    <div class="box-footer" style="float:right">
        <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ url('backend/locations')}}" class="btn btn-primary">Back</a>
    
    </div>
    <input type="hidden" name="blog" value="1">
    
    </form>
    </div><!-- /.box -->
    
    <!-- Form Element sizes -->
    </div>
</div><!-- /.row -->

@stop
@section('extra-js')

<script>
    $(document).ready(function(){
		  $('#category_id').on('change',function(){

        var stateID = $(this).val();
        if(stateID){
          $.ajax({
            type:'GET',
            url:'../categoryeditData',
            data:'category_id='+stateID,
            success:function(html){
//alert('hello');
$('#subcategories_id').html(html);

}
}); 
        }else{
          $('#subcategories_id').html('<option value="">Select category first</option>');

        }
      }); 
	  
	 $('#type').on('change',function(){
        var value = $(this).val();
        //alert(value);
        if(value==1)
        {
            $("#price").css("display", "block");
            $("#unit").css("display", "block");
            $("#qty").css("display", "block");
            
        }
        else if(value==2)
        {
            $("#price").css("display", "none");
            $("#unit").css("display", "none"); 
            $("#qty").css("display", "none");   
        }
       
    });   
     
	  
	})


</script>


@endsection


