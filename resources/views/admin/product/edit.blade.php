@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @if(Auth::user()->roles_id == 1)
         View Product
         @else
         Edit Product
         @endif
         
     </h1>
     <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/product')}}">Products</a></li>
        <li class="active">@if(Auth::user()->roles_id == 1) {{'View Product'}} @else {{'Edit Product'}} @endif</li>
    </ol> 
</section>

<!-- Main content -->
<section class="content">
    <div class="row">

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                @foreach ($errors->all() as $error)
                    <div class=" alert alert-danger">
                       <span class="glyphicon glyphicon-remove"></span>{{ $error }}
                   </div>
                   @endforeach
                   @if(Session::has('error_message')) <div class=" alert alert-danger"> 
                   <span class="glyphicon glyphicon-remove"></span> {!! session('error_message') !!}
                 </div>@endif
                <!--    <h3 class="box-title">Create country</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <form name="form" action=" {{ url('admin/editproduct',[$product->id]) }}" method="post" enctype="multipart/form-data">


                <div class="box-body">
                    
                    <div class="form-group">
						<label for="Parent customer">Select Product Menu</label>
						<select class="form-control" name="product_cat_id" required @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
						<option value=''>Select Menus</option>    
						@foreach($menus as $menu)
							<option value="{{$menu->id}}" @php if($product->product_cat_id==$menu->id){ echo 'selected'; } @endphp>{{ $menu->menu_name}}</option>
						@endforeach
						</select> 
					</div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name"  placeholder="Product Name" required value="{{ $product->name}}" @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Description</label>
                    <textarea class="ckeditor"  id="description" name="description" @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>{{ $product->description }}</textarea>
                    </div>
                    
                     <div class="row">
                         
                          <div class="form-group col-md-6">
                    
                    <label for="exampleInputEmail1">Featured Image</label>
                    <input type="hidden" name="img" value="{{ $product->img}}">
                    <input type="file" class="form-control" id="img" name="img" placeholder="Image" @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
                    <img style="margin-top:10px;" src="{!! asset($product->img)!!}" height='80'>
                </div>
                <div class="form-group col-md-6">
                        <label for="exampleInputEmail">Price</label>
                        <input type="text" class="form-control"  name="price"  placeholder="Price"  value="{{ $product->price}}" @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
                    </div>
                         
                     
                    </div>
                    
                    <div class="form-group">
						<label for="Parent customer">Is Customisable</label>
						<select id="is_customisable" class="form-control" name="is_customisable" required @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
						<option value=''>--Select--</option>    
							<option value="0" @php if($product->is_customisable==0){ echo 'selected'; } @endphp>{{'No'}}</option>
							<option value="1" @php if($product->is_customisable==1){ echo 'selected'; } @endphp>{{'Yes'}}</option>
						</select> 
					</div>
					
					<div id="toHide" class="form-group" @if($product->is_customisable==0) style="display:none;" @else style="display:block;" @endif @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
                      
                        <table class="table table-bordered superviser_table" id="sub_learning">
    <thead><tr><th>Select Customization</th>
        <th>Type</th>
        <th>Price</th></tr></thead>
<tbody id="sub_module_data">    
@if($dishCust && (count($dishCust)>0))
@foreach($dishCust as $learning_sub_module)
<tr>
<td>			
 <select class="form-control" name="custom[]" required @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
    <option value=''>--Select--</option>    
    @foreach($custom as $customs)
    <option value="{{$customs->id}}" @if($learning_sub_module->cutomisation == $customs->id) {{ 'selected="true"'}} @endif >{{ $customs->name}}</option>
@endforeach
</select> 
</td>
<td>
 <input type="text" name="type[]" value="{{$learning_sub_module->type}}" class="form-control" @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
</td>
<td> 
  <input type="text" name="prices[]" value="{{$learning_sub_module->prices}}" class="form-control" @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
</td>
</tr>
@endforeach
@endif
</tbody>
@if(Auth::user()->roles_id == 3)
<tfoot> <tr><th align:center>  <a href="javascript:void(0);" id="add_sub_module" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></a>
<a href="javascript:void(0);" id="remove" name="remove" class="btn btn-danger btn-sm remove_sub_module"><span class="glyphicon glyphicon-minus"></span></a></th></tr> </tfoot>
@endif
</table>  
                
                        </div>
                    
                    
                    {{csrf_field()}}
                    <div class="form-group">
                     <label for="status"> Status</label>

                     <select class="form-control" name="status" required @if(Auth::user()->roles_id == 1) {{'disabled'}} @endif>
                        <option value=''>--Select option--</option>
                        <option value='1' @if($product->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                        <option value='0' @if($product->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
                        

                    </select> 
                </div>
                
                
                
            </div><!-- /.box-body -->
@if(Auth::user()->roles_id == 3)
            <div class="box-footer" style="float:right">
              
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="reset" class="btn btn-primary">Cancel</button>
          </div>
@endif          
          <input type="hidden" name="country" value="1">
          
								
                                </form>
                            </div><!-- /.box -->
                            <!-- Form Element sizes -->
                        </div>
                    </div><!-- /.row -->
                </section>
            </aside>
<script>
$("#add_sub_module").click(function () {
    var custom = <?php echo $custom ?>;
    // var url= '../admin/customisation'; 
    $.ajax({
	    url: '../../customisation',
	//data{'portal_type':'audio', "_token": "{{ csrf_token() }}" },
        data: {
        "_token": "{{ csrf_token() }}",
        "custom": custom,
        },
	type:"POST",       
	success:function(data){
		$('#sub_module_data').append(data);
	},
	error:function (){}
	});
    
     
});

$('.remove_sub_module').on("click", function(){
var count = $('#sub_module_data tr').length; 
//alert(count);
   if (count >1) {
    $('#sub_module_data tr:last').remove();
     }
   
})
</script>
            @stop
            
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
   
    $('#is_customisable').on('change',function(){
        var value = $(this).val();
        //alert(value);
        if(value==1)
        {
            $("#toHide").css("display", "block");
        }
        else
        {
           $("#toHide").css("display", "none");
        }
       
    });   
    
});
</script>