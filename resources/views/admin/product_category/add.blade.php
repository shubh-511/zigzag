@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Category
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/product-category')}}">Product Category</a></li>
            <li class="active">Add Product Category</li>
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
               <form name="form" action=" {{ url('admin/saveproduct_cat') }}" method="post"  enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name"  placeholder="Category Name" required value="<?php echo   isset($row)? $row['name'] : ''?>">
                    </div>
                    
                  
                    
                    <div class="form-group">
                    <label for="exampleInputEmail1">Featured Image</label>
                    
                    <input type="file" class="form-control" id="cat_img" name="cat_img" placeholder="Image" required>
                
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