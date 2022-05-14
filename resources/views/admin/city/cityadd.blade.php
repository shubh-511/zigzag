@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create city
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="{{ url('admin/city')}}">City</a></li>
            <li class="active">Add City</li>
        </ol>    
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <!--    <h3 class="box-title">Create city</h3>-->
                        @foreach ($errors->all() as $error)
                        <div class=" alert alert-danger">
                            <span class="glyphicon glyphicon-remove"></span>{{ $error }}
                        </div>
                        @endforeach
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form city="form" action="{{ url('admin/savecity')}}" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Parent customer">Country</label>
                                <select class="form-control" id="country_id" name="country_id" required>
                                    <option value=''>Select Country</option>
                                    @foreach($countries as $country)
                                    <option value='{{ $country->id}}' >{{ $country->name}}</option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label for="Parent customer">State</label>
                                <select class="form-control" id="state_id" name="state_id" required>

                                </select> 
                            </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Name</label>
                            <input type="text" class="form-control"  id="name" name="name" placeholder="Name" required >
                        </div>
<!--====================Start Tax for State============-->              
              <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="exampleInputEmail">City Tax(%)</label>
                <input type="text" class="form-control" id="city_tax" name="city_tax" placeholder="City Tax" required >
              </div>              
<!--====================End Tax for State============-->


                            <div class="form-group">
                                <label for="status"> Status</label>

                                <select class="form-control" name="status" required>
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select> 
                            </div>



                        </div><!-- /.box-body -->

                        <div class="box-footer" style="float:right">
                            
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-primary">Cancel</button>
                        </div>
                        <input type="hidden" name="city" value="1">
                    </form>
                </div><!-- /.box -->

                <!-- Form Element sizes -->
            </div>
        </div><!-- /.row -->

        @stop

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){

                $('#country_id').on('change',function(){

                    var countryID = $(this).val();
                    if(countryID){
                        $.ajax({
                            type:'GET',
                            url:'stateData',
                            data:'country_id='+countryID,
                            success:function(html){
//alert('hello');
$('#state_id').html(html);

}
}); 
                    }else{
                        $('#state_id').html('<option value="">Select country first</option>');

                    }
                });   

            });
        </script>