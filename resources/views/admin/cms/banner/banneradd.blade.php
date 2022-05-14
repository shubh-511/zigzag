@extends('layouts.adminlay')
@section('content')

<aside class="right-side">
    <!-- Content Header (banner header) -->
    <section class="content-header">
        <h1>
            Create Banner
            <!--<small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/banner')}}">Banner</a></li>
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
                        <!-- <h3 class="box-title">Create Menu</h3>-->
                        @foreach ($errors->all() as $error)
                        <div class=" alert alert-danger">
                            <span class="glyphicon glyphicon-remove"></span>{{ $error }}
                        </div>
                        @endforeach
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('admin/savebanner')}}" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control"  id="name" name="name" placeholder="Name" required value="">
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Place Holder</label>
                                <select class="form-control" name="placeholder" required>
                                    <option value=''>Select Place</option>
                                    <option value='1'>Home</option>
                                    <option value='2'>Inner</option>
                                    <option value='3'>Page</option>
                                    <option value='4'>Back</option>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Content (data to be display on banner)</label>
                                <textarea class="ckeditor"  id="content" name="content"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Banner Image</label>
                                <input type="file" class="form-control" id="image" name="image" placeholder="Image" required>
                            </div>


                            <div class="form-group">
                                <label for="Parent Menu">Page</label>
                                <select class="form-control" name="page" required>
                                    <option value=''>Page</option>
                                    @foreach($pages as $page)

                                    <option value='{{ $page->id}}'>{{ $page->name}}</option>";

                                    @endforeach
                                </select> 
                            </div>

                            <div class="form-group">
                                <label for="status"> Status</label>
                                <select class="form-control" name="status" required>
                                    <option value=''>--Select Status--</option>
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select> 
                            </div>



                        </div><!-- /.box-body -->

                        <div class="box-footer" style="float:right">
                             <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-primary">Cancel</button>
                           
                        </div>
                    </form>
                </div><!-- /.box -->

                <!-- Form Element sizes -->
            </div>
        </div><!-- /.row -->
        @stop
        