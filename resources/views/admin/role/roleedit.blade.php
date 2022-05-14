@extends('layouts.adminlay')
@section('content')
<?php //echo '<pre>';print_r($roles);?>
<aside class="right-side">
  <section class="content-header">
    <h1>Edit Role</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('admin/role')}}">Role</a></li>
      <li class="active">Edit Role</li>
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
                 <form role="form" action="{!! url('admin/editrole',[$role->id]) !!}" method="post">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail">Name</label>
  <input type="text" class="form-control" id="name" name="name" required value="{{ $role->name }}"> 
                       </div>
                         
                     <div class="form-group">
                        <label for="status">Select Status</label>
                            <select class="form-control" name="status" required>
                              <option value="1" @if($role->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                              <option value="0"  @if($role->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
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
                    </div>
                    @stop