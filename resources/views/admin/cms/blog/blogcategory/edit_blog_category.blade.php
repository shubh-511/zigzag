    @extends('layouts.adminlay')
    @section('content')
    <aside class="right-side">
        <!-- Content Header (blog header) -->
        <section class="content-header">
            <h1>
                Edit Blog Category
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{ url('admin/blogcategory')}}">Blog Category</a></li>
                <li class="active">Edit Blog Category</li>
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
                            @foreach ($errors->all() as $error)
                            <div class=" alert alert-danger">
                               <span class="glyphicon glyphicon-remove"></span>{{ $error }}
                           </div>
                           @endforeach
                       </div><!-- /.box-header -->
                       <!-- form start -->
                       <form role="form" action="{{ url('admin/editblogcategory',[$bcat_data->id])}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Blog Category Title</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Category Title"  value="{{ $bcat_data->name}}" required >
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category Tag</label>
                                <input type="text" class="form-control" id="tag" name="tag" placeholder="Category Tag" value="{{ $bcat_data->tag}}">
                            </div>
                            

                            
                            <div class="form-group">
                                <label for="status"> Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="0">--Select Status--</option>
                                    <option value='1' @if($bcat_data->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                                    <option value='0'  @if($bcat_data->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
                                </select> 
                            </div>
                        </div><!-- /.box-body -->
                        
                        <div class="box-footer" style="float:right">
                            <button type="reset" class="btn btn-primary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <input type="hidden" name="blog" value="1">
                        
                    </form>
                </div><!-- /.box -->
                
                <!-- Form Element sizes -->
            </div>
        </div><!-- /.row -->
        
        @stop