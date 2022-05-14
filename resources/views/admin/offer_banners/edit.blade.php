@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Edit Banner
         
     </h1>
     <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/banners')}}">Banners</a></li>
        <li class="active">Edit Banner</li>
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
            <form name="form" action=" {{ url('admin/banner_edit',[$banner->id]) }}" method="post" enctype="multipart/form-data">


                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail">Banner Title</label>
                        <input type="text" class="form-control" id="name" name="name"  placeholder="Banner Title" required value="{{ $banner->name}}">
                    </div>
                    
                    
                     <div class="form-group">
                     <label for="status"> Banner Type</label>

                     <select class="form-control" name="status" required>
                        <option value=''>--Select option--</option>
                        <option value='1' @if($banner->status=='1') {{ 'selected="true"'}} @endif>Simple Banner</option>
                        <option value='2' @if($banner->status=='2') {{ 'selected="true"'}} @endif>Offer Banner</option>
                        

                    </select> 
                </div>
                    
                    <div class="form-group">
                    
                    <label for="exampleInputEmail1">Featured Image</label>
                    <input type="hidden" name="img" value="{{ $banner->img}}">
                    <input type="file" class="form-control" id="img" name="img" placeholder="Image">
                    <img style="margin-top:10px;" src="{!! asset($banner->img)!!}" height='80'>
                </div>
                
               
                    
                    
                    {{csrf_field()}}
                    <div class="form-group">
                     <label for="status"> Status</label>

                     <select class="form-control" name="status" required>
                        <option value=''>--Select option--</option>
                        <option value='1' @if($banner->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                        <option value='0' @if($banner->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
                        

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
                </section>
            </aside>

            @stop