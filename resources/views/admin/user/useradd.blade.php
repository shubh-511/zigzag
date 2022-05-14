@extends('layouts.adminlay')
@section('content')
<?php //echo '<pre>';print_r($roles);?>
<aside class="right-side">
   <section class="content-header">
      <h1>Create User</h1>
        <ol class="breadcrumb">
          <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="{{ url('admin/user')}}">User</a></li>
          <li class="active">Add User</li>
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
                 <form role="form" action="{!! url('admin/saveuser') !!}" method="post">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail">Name</label>
                         <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
 
                       </div>
                        <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                            <input type="text" class="form-control" id="email" name="email"  required value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail">Password</label>
                            <input type="Password" class="form-control" id="password" name="password"  required value="">
                        </div>
                       
                        {{--<div class="form-group">
                        <label for="status">Role</label>
                            <select class="form-control" name="role_id" required>

                            @foreach($roles as $role)                         
                               <option value="{{$role->id}}" @if(old('role_id') == $role->id) selected @endif >{{$role->name}}</option>
                            @endforeach
                            </select> 
                    </div>--}}
                      </div><!-- /.box-body -->

                                    <div class="box-footer" style="float:right">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="reset" class="btn btn-primary">Cancel</button>
                                        
                                    </div>
                                    <input type="hidden" name="user" value="1">
                                    
                                    
                                    <input type="hidden" name="user_id" value="" />
                                     
                                </form>
                            </div><!-- /.box -->

                            <!-- Form Element sizes -->
                        </div>
                    </div>
                    @stop