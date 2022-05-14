@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create Country
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/country')}}">Country</a></li>
            <li class="active">Add Country</li>
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
               </div><!-- /.box-header -->
               <!-- form start -->
               <form name="form" action=" {{ url('admin/savecountry') }}" method="post"  enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail">Country Name</label>
                        <input type="text" class="form-control" id="name" name="name"  placeholder="Name" required value="<?php echo   isset($row)? $row['name'] : ''?>">
                    </div>
                    
                    <!--<div class="form-group">-->
                    <!--    <label for="exampleInputEmail">Country Code</label>-->
                    <!--    <input type="text" class="form-control" id="country_code" name="country_code"  placeholder="eg. 91" required value="{{old('country_code')}}">-->
                    <!--</div>-->
                    
                    <!--<div class="form-group">-->
                    <!--    <label for="exampleInputEmail">Flag</label>-->
                    <!--    <input type="file" class="form-control" id="flag_image" name="flag_image" required >-->
                    <!--</div>-->
                    
                    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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