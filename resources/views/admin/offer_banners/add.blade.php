@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Banner
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/banners')}}">Banners</a></li>
            <li class="active">Add Banner</li>
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
                    @foreach ($errors->all() as $error)
                    <div class=" alert alert-danger">
                       <span class="glyphicon glyphicon-remove"></span>{{ $error }}
                   </div>
                   @endforeach
                    @if(Session::has('err_message')) <div class=" alert alert-danger"> 
              <span class="glyphicon glyphicon-remove "></span><em> {!! session('err_message') !!}</em>
            </div>@endif
               </div><!-- /.box-header -->
               <!-- form start -->
               <form name="form" action=" {{ url('admin/save_banner') }}" method="post"  enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail">Banner Title</label>
                        <input type="text" class="form-control" id="name" name="name"  placeholder="Banner title" required >
                    </div>
                    
                    <div class="form-group">
                     <label for="status"> Banner Type</label>

                     <select class="form-control" name="type" required>
                       <option value=''>--Select option--</option>
                        <option value='1'>Simple Banner</option>
                        <option value='2'>Offer Banner</option>
                        

                    </select> 
                </div>
                    
                    <div class="form-group">
                    <label for="exampleInputEmail1">Featured Image</label>
                    
                    <input type="file" class="form-control" id="img" name="img" placeholder="Image">
                
                    </div>
                    
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                     <label for="status"> Status</label>

                     <select class="form-control" name="status" required>
                       <option value=''>--Select option--</option>
                        <option value='1'>Active</option>
                        <option value='0'>Inactive</option>
                        

                    </select> 
                </div>
                
                
                
            </div><!-- /.box-body -->

            <div class="box-footer" style="float:right">
              
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="reset" class="btn btn-primary">Cancel</button>
          </div>
          <input type="hidden" name="country" value="1">
          
									<!-- <?php if(isset($row)== TRUE){ ?>
									<input type="hidden" name="country_id" value="<?= $row['id']?>" />
									 <?php } ?>
									-->
                                </form>
                            </div><!-- /.box -->
                            <!-- Form Element sizes -->
                        </div>
                    </div><!-- /.row -->

                    @stop