@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (blog header) -->
    <section class="content-header">
        <h1>
            Edit Comment
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/comment')}}">Comment</a></li>
            <li class="active">Edit Comment</li>
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
                    <form role="form" action="{{ url('admin/editcomment',[$comment->id])}}" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="form-group">
                            <label for="status"> Blog</label>
                            <select class="form-control" name="blog_id" required>
                                <option value="0">--Blogs--</option>
                                @foreach($blogs as $blog)

                                <option value="{{$blog->id}}" @if($blog->id==$comment->blog_id) {{ 'selected="true"'}} @endif>{{ $blog->name}}</option>
                                
                                @endforeach
                            </select> 
                        </div>
                        

                        <div class="form-group">
                            <label for="exampleInputEmail1">Author</label>
                            <input type="text" class="form-control" id="author_name" name="author_name" placeholder="Name" required value="{{$comment->author_name}}">
                        </div>
                        

                        <div class="form-group">
                            <label for="exampleInputEmail1">Content</label>
                            <textarea class="ckeditor"  id="content" name="content" >{{ $comment->content }}</textarea>
                        </div>
                        

                        
                        <div class="form-group">
                            <label for="status"> Status</label>
                            <select class="form-control" name="status" required>
                                <option value="0">--Select Status--</option>
                                <option value='1' @if($comment->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                                <option value='0'  @if($comment->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
                            </select> 
                        </div>
                    </div><!-- /.box-body -->
                    
                    <div class="box-footer" style="float:right">
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="reset" class="btn btn-primary">Cancel</button>
                        
                    </div>
                    <input type="hidden" name="blog" value="1">
                    
                </form>
            </div><!-- /.box -->
            
            <!-- Form Element sizes -->
        </div>
    </div><!-- /.row -->

    @stop