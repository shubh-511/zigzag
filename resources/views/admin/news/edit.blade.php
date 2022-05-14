@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Edit News
         
     </h1>
     <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/news')}}">News</a></li>
        <li class="active">Edit News</li>
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
            <form name="form" action=" {{ url('admin/editnews',[$news->id]) }}" method="post" enctype="multipart/form-data">


                <div class="box-body">
                    
                   
                    
                    <div class="form-group">
                        <label for="exampleInputEmail">News Title</label>
                        <input type="text" class="form-control" id="title" name="title"  placeholder="Title" required value="{{ $news->title}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Description</label>
                    <textarea class="ckeditor"  id="description" name="description" >{{ $news->description }}</textarea>
                    </div>
                    
                     
                         
                          <div class="form-group">
                    
                    <label for="exampleInputEmail1">Featured Image</label>
                    <input type="hidden" name="img" value="{{ $news->img}}">
                    <input type="file" class="form-control" id="img" name="img" placeholder="Image">
                    <img style="margin-top:10px;" src="{!! asset($news->img)!!}" height='80'>
                </div>
                     
                    
                    {{csrf_field()}}
                    <div class="form-group">
                     <label for="status"> Status</label>

                     <select class="form-control" name="status" required>
                        <option value=''>--Select option--</option>
                        <option value='1' @if($news->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                        <option value='0' @if($news->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
                        

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