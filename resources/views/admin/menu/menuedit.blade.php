@extends('layouts.adminlay')
@section('content')

<aside class="right-side">
  <section class="content-header">
    <h1>Edit Menu
    </h1> 
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('admin/menu')}}">Menu</a></li>
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
     <form role="form" action="{!! url('admin/editmenu',[$data->id]) !!}" method="post">
       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
       <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail">Name</label>
          <input type="text" class="form-control" id="name" name="name" required value="{{ $data->name }}">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail">Action</label>
          <input type="text" class="form-control"id="url" name="url" required="" placeholder="url" value="{{ $data->url }}"/>
        </div>
      <?php /*  <div class="form-group">
          <label for="exampleInputEmail">Controller</label>
          <input type="text" class="form-control"id="controller" name="controller" placeholder="Controller" 
          value="{{ $data->controller }}"/>
        </div>
        <div class="form-group">
         <label for="exampleInputEmail">Action</label>
         <input type="text" class="form-control"id="action" name="action" placeholder="Action" 
         value="{{ $data->action }}"/>
       </div>
       
       */
       ?>
       <div class="form-group">
        <label for="exampleInputEmail">Icon Class</label>
        <input type="text" class="form-control" id="icon" name="icon" placeholder="icon" 
        value="{{ $data->icon }}"/>
      </div>
      
      <div class="form-group">
        <label for="status">Parent Menu</label>                        

        <select class="form-control" name="parent_menu_id" >
          <option value="0">Select</option>>
          @foreach($pmenus as $pmenu)                         
          <option value="{{$pmenu->id}}" @if($data->parent_menu_id == $pmenu->id) {{ 'selected="true"'}} @endif >{{$pmenu->name}}</option>
        @endforeach </select>
        
      </div>
      <div class="form-group">
        <label for="status">Status</label>     
        <select class="form-control" name="status">
          <option value="1" @if($data->status=='1') {{ 'selected="true"'}} @endif>Active</option>
          <option value="0" @if($data->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
        </select>
      </div>
      
      
      <div class="form-group">
        <label for="exampleInputEmail">Priority</label>
        <input type="text" class="form-control" id="priority" name="priority" placeholder="priority" value="{{ $data->priority}}"/>
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