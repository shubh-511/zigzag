@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (blog header) -->
    <section class="content-header">
        <h1>
            Edit Blog
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/blog')}}">Blog Category</a></li>
            <li class="active">Edit Blog</li>
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
                    <form role="form" action="{{ url('admin/editblog',[$blog->id])}}" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{$blog->name}}">
                            </div>

                            <div class="form-group">
                                <label for="status"> Blog Category</label>
                                <select class="form-control" name="blog_category_id" required>
                                    <option value="0">--Select Category--</option>
                                    @if(!empty($bcats))
                                    @foreach($bcats as $bcat)
                                    <option value='{{$bcat->id}}' @if($bcat->id==$blog->blog_category_id) {{'selected="true"'}} @endif>{{ $bcat->name}}</option>
                                    @endforeach
                                    @endif
                                </select> 
                            </div>
                            

                            <ul class="nav nav-tabs faq-page">
                             <li class="active"><a data-toggle="tab" href="#menu1">Short Description</a></li>
                             <li><a data-toggle="tab" href="#menu2">Description</a></li>
                         </ul>

                         <div class="tab-content">    
                            <div id="menu1" class="tab-pane fade in active">
                                <div class="form-group">
                                  <textarea class="ckeditor"  id="short_description" name="short_description" >{{ $blog->short_description }}</textarea>
                              </div>
                          </div>
                          
                          <div id="menu2" class="tab-pane fade">
                           <div class="form-group">
                              <textarea class="ckeditor"  id="long_description" name="long_description" >{{ $blog->long_description }}</textarea>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <label for="exampleInputEmail1">Feature Image</label>
                    <input type="hidden" name="fimage" value="{{ $blog->image}}">
                    <input type="file" class="form-control" id="image" name="image" placeholder="Image">
                    <img src="{!! asset($blog->image)!!}" height='80'>
                </div>
                
                <div class="form-group">
                    <label for="status"> Status</label>
                    <select class="form-control" name="status" required>
                        <option value="0">--Select Status--</option>
                        <option value='1' @if($blog->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                        <option value='0'  @if($blog->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
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