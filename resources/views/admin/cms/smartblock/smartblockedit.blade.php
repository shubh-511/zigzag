@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Smartblock
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/smartblock')}}">Smart block</a></li>
            <li class="active">Edit Smart block</li>
        </ol>
        
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

          <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <!--    <h3 class="box-title">Create smartblock</h3>-->
                </div><!-- /.box-header -->
                <!-- form start -->
                <form smartblock="form" action="{{ url('admin/editsmartblock',[$smartblock->id])}}" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                           <label for="exampleInputEmail">Name</label>
                           <input type="text" class="form-control" title="Name should be Alphabet" id="name" name="name" placeholder="Name" required value="{{ $smartblock->name}}" >
                       </div>
                       
                       <div class="form-group">
                          <label for="exampleInputEmail1">Content</label>
                          <textarea class="ckeditor"  id="content" name="content" >{{ $smartblock->content}}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Smart Block Image (optional)</label>
                        <input type="file" class="form-control" id="image" name="image" placeholder="Image">
                        <input type="hidden" name='fimage' value="{{ $smartblock->image}}"/>
                        <img src="{!! asset($smartblock->image)!!}"  height='80'>
                    </div>
                    
                    <div class="form-group">
                        <label for="parentpage">Parent Page (page where the block will display)</label>
                        <select class="form-control" name="page_id" required>
                            <option value="0">Select Page</option>
                            @foreach($pages as $page)
                            <option value='{{ $page->id}}' @if($page->id==$smartblock->page_id) {{'selected="true"'}} @endif>{{ $page->name}}</option>
                            @endforeach
                        </select> 
                    </div>

                    <div class="form-group">
                      <label for="status"> Status</label>
                      <select class="form-control" name="status" required>
                         <option value="0">Please Select Status</option>
                         <option value='1' @if($smartblock->status=='1') {{'selected="true"'}} @endif>Active</option>
                         <option value='0'  @if($smartblock->status=='0') {{'selected="true"'}} @endif>Inactive</option>
                     </select> 
                 </div>
                 
             </div><!-- /.box-body -->

             <div class="box-footer" style="float:right">
              <button type="reset" class="btn btn-primary">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
          </div>
      </form>
  </div><!-- /.box -->
  <!-- Form Element sizes -->
</div>
</div><!-- /.row -->
@stop