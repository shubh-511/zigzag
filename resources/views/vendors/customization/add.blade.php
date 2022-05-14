@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
  <section class="content-header">
    <h1>Create Menu</h1> 
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('admin/customization')}}">Customization</a></li>
      <li class="active">Add customization</li>
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
     <form role="form" action="{{ route('customization.store') }}" method="post">
       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
       
	   <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail">Name</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"> 
        </div> 
     
      <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" name="status" required>
          <option value="1">Active</option>
		  <option value="0">Inactive</option>          
        </select> 
      </div>      
    </div>

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