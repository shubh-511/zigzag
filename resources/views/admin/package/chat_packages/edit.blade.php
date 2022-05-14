@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Edit Package
         
     </h1>
     <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/chat-packages')}}">Package</a></li>
        <li class="active">Edit Package</li>
    </ol> 
</section>

<!-- Main content -->
<section class="content">
    <div class="row">

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--    <h3 class="box-title">Create country</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <form name="form" action=" {{ url('admin/editchat_package',[$package->id]) }}" method="post" enctype="multipart/form-data">


                <div class="box-body">
                    
                    
                    
                    <div class="form-group">
                        <label for="exampleInputEmail">Price</label>
                        <input type="text" class="form-control" id="price" name="price"  placeholder="Price" required value="{{ $package->price}}">
                    </div>
                    
                    {{-- <div class="form-group">
    <label for="Parent customer">Select Period</label>
    <select class="form-control" name="period" required>
    <option value=''>--Select Period--</option>
    
    <option value="1" @if($package->period=='1') {{ 'selected="true"'}} @endif>1 Month</option>
							<option value="2" @if($package->period=='2') {{ 'selected="true"'}} @endif>2 Months</option>
							<option value="3" @if($package->period=='3') {{ 'selected="true"'}} @endif>3 Months</option>
							<option value="4" @if($package->period=='4') {{ 'selected="true"'}} @endif>4 Months</option>
							<option value="5" @if($package->period=='5') {{ 'selected="true"'}} @endif>5 Months</option>
							<option value="6" @if($package->period=='6') {{ 'selected="true"'}} @endif>6 Months</option>
							<option value="7" @if($package->period=='7') {{ 'selected="true"'}} @endif>7 Months</option>
							<option value="8" @if($package->period=='8') {{ 'selected="true"'}} @endif>8 Months</option>
							<option value="9" @if($package->period=='9') {{ 'selected="true"'}} @endif>9 Months</option>
							<option value="10" @if($package->period=='10') {{ 'selected="true"'}} @endif>10 Months</option>
							<option value="11" @if($package->period=='11') {{ 'selected="true"'}} @endif>11 Months</option>
							<option value="12" @if($package->period=='12') {{ 'selected="true"'}} @endif>12 Months</option>

     
    </select> 
</div>--}}
                     
                    
                    {{csrf_field()}}
                    <div class="form-group">
                     <label for="status"> Status</label>

                     <select class="form-control" name="status" required>
                        <option value=''>--Select option--</option>
                        <option value='1' @if($package->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                        <option value='0' @if($package->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
                        

                    </select> 
                </div>
                
                
                
            </div><!-- /.box-body -->

            <div class="box-footer" style="float:right">
              
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="reset" class="btn btn-primary">Cancel</button>
          </div>
          <input type="hidden" name="country" value="1">
          
								
                                </form>
                            </div><!-- /.box -->
                            <!-- Form Element sizes -->
                        </div>
                    </div><!-- /.row -->
                </section>
            </aside>

            @stop
            
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
   
    $('#is_discount').on('change',function(){
        var value = $(this).val();
        //alert(value);
        if(value==1)
        {
            $("#old_price").css("display", "block");
            $("#new_price").css("display", "block");
            
            
        }
        else if(value==0)
        {
            $("#new_price").css("display", "none");
            $("#old_price").css("display", "block"); 
           
        }
        else 
        {
            $("#new_price").css("display", "none");
            $("#old_price").css("display", "none"); 
           
        }
       
    });   
    
});
</script>