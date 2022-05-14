@extends('layouts.adminlay')
@section('content')

<aside class="right-side">
  <section class="content-header">
    <h1>Edit Menu
    </h1> 
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('provider-menu.index')}}">Menu</a></li>
      <li class="active">Edit menu</li>
    </ol>
  </section>
  <section class="content">
   <div class="row">
    <div class="col-md-12">
     <div class="box box-primary">
      <div class="box-header"> 
       @foreach ($errors->all() as $error)
       <div class=" alert alert-danger">
         <span class="glyphicon glyphicon-remove"></span>{{ $error }}
       </div>
       @endforeach

     </div><!-- /.box-header -->
     <form role="form" action="{!! url('provider-menu/update_menu',[$data->id]) !!}" method="post" enctype="multipart/form-data">
       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
       <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail">Name</label>
          <input type="text" class="form-control" id="name" name="name" required value="{{ $data->menu_name }}">
        </div>
        
        <div class="form-group">
                    
                    <label for="exampleInputEmail1">Menu Icon</label>
                    <input type="hidden" name="menu_icon" value="{{ $data->menu_icon}}">
                    <input type="file" class="form-control" id="menu_icon" name="menu_icon" placeholder="Image">
                    <img style="margin-top:10px;" src="{!! asset($data->menu_icon)!!}" height='80'>
                </div>
      
      <div class="form-group">
        <label for="status">Status</label>     
        <select class="form-control" name="status">
          <option value="1" @if($data->status=='1') {{ 'selected="true"'}} @endif>Active</option>
          <option value="0" @if($data->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
        </select>
      </div> 
     
    </div><!-- /.box-body -->

    <div class="box-footer" style="float:right">
      
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="reset" class="btn btn-primary">Cancel</button>
    </div>
    
    
    <input type="hidden" name="id" value="{{ $data->id }}" />
    
  </form>
</div><!-- /.box -->

<!-- Form Element sizes -->
</div>
</div>
@stop