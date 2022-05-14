@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
  <section class="content-header">
    <h1>Permission</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Permission</li>
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
     
     <form role="form" action="{{ url('admin/savepermission')}}" method="post">
        <div class="box-body">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="form-group">
    <label for="Parent customer">Select Roles</label>
    <select class="form-control" id="role_id" name="role_id" required>
      <option value="10">Select Role</option>
      @foreach($roles as $role)
      <option value="{{$role->id}}">{{ $role->name}}</option>
      @endforeach
    </select> 
    <?php //print_r($subs);?>
  </div>



  <div class="box-body table-responsive">
    <table id="example1" class="table table-bordered table-striped" >
    
     
    </table> 
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
  /*
    $('#role_id').on('change',function(){
    
        var roleID = $(this).val();
        if(roleID){
            $.ajax({
                type:'GET',
                url:'../admin/getPermission',
                data:'role_id='+roleID,
                success:function(data){
                  //alert(data);
                  //alert('hello');
                  //$('#example1').html(html);
                location.reload();
                    
                }
            }); 
        }
         
    }); */ 
    $('#role_id').on('change',function(){
     //alert('hello');
        var roleID = $(this).val();
        if(roleID){
            $.ajax({
                type:'GET',
                url:'permissionData',
                data:'role_id='+roleID,
                success:function(html){
                  //alert('hello');
                  $('#example1').html(html);
                    
                }
            }); 
        }
        /*else{
            $('#example1').html('<option value="">Select Role first</option>');
           
        }*/
    });   
    
});

</script>



<?php /*   <tr style="width:350px; position:relative; left:45px !important;">
    <td>
      <label for="checkbox">
      <input type="checkbox" class="form-control" name="privilege[]"
      value="{{ $main_menu->id}}" @if(in_array($main_menu->id,$mains)) {{'checked'}} @endif>
      <strong>{{ $main_menu->name }}</strong>
      </label>
    </td>
  </tr>


 <tr>
    <td>
      <label for="checkbox"><input type="checkbox" class="form-control" id="name" name="privilege[]" value="{{ $main_menu->id}}" @if(in_array($main_menu->id,$mains)) {{'checked'}} @endif>
      <strong>{{ $main_menu->name }}</strong> </label> 

    </td>
  </tr>
  */ ?>