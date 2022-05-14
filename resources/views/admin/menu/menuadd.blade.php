@extends('layouts.adminlay')
@section('content')
<?php //echo '<pre>';print_r($roles);?>
<aside class="right-side">
  <section class="content-header">
    <h1>Create Menu</h1> 
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('admin/menu')}}">Menu</a></li>
      <li class="active">Add menu</li>
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
     <form role="form" action="{!! url('admin/savemenu') !!}" method="post">
       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
       <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail">Name</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"> 
        </div>
        <div class="form-group">
          <label for="exampleInputEmail">Action</label>
          <input type="text" class="form-control"id="url" name="url" placeholder="url" value="{{ old('url') }}"/>
        </div>
     <?php /*   <div class="form-group">
          <label for="exampleInputEmail">Controller</label>
          <input type="text" class="form-control"id="controller" name="controller" placeholder="Controller" value="{{ old('controller') }}"/>
        </div>
        <div class="form-group">
         <label for="exampleInputEmail">Action</label>
         <input type="text" class="form-control"id="action" name="action" placeholder="Action" 
         value="{{ old('action') }}"/>
       </div>
       */
       ?>
       <div class="form-group">
        <label for="exampleInputEmail">Icon Class</label>
        <input type="text" class="form-control" id="icon" name="icon" placeholder="icon" 
        value="{{ old('icon') }}"/>
      </div>
      <div class="form-group">
        <label for="status">Parent Menu</label>
        <select class="form-control" name="parent_menu_id" required>
          <option value="0">--Parent menu--</option>
          @foreach($pmenu as $menu_id)                         
          <option value="{{$menu_id->id}}" @if(old('parent_menu_id') == $menu_id->id) selected @endif >{{$menu_id->name}}</option>
          @endforeach
        </select> 
      </div>
      
      <div class="form-group">
        <label for="exampleInputEmail">Priority</label>
        <input type="text" class="form-control" id="priority" name="priority" placeholder="priority" value="{{ old('priority') }}"/>
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
</div>
@stop