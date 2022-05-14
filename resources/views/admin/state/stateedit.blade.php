@extends('layouts.adminlay')
@section('content')

<aside class="right-side">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create state
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li><a href="{{ url('admin/state')}}">State</a></li>
      <li class="active">Edit State</li>
    </ol>    
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header">
            <!--    <h3 class="box-title">Create state</h3>-->
          </div><!-- /.box-header -->
          <!-- form start -->

          <form state="form" action="{{ url('admin/editstate',[$state->id])}}" method="post">
            <div class="box-body">
              <div class="form-group">
                <label for="Parent customer">Country</label>
                <select class="form-control" name="country_id" required>
                  <option value=''>Select Country</option>

                  @foreach($countries as $country)
                  @if($state->country_id==$country->id)
                  <option value="{{$country->id}}" selected="true">{{    $country->name}}</option>
                  @else
                  <option value="{{$country->id}}">{{$country->name}}</option>
                  @endif

                  @endforeach


                </select> 
              </div>
              <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="exampleInputEmail">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{ $state->name}}" >
              </div>

     <div class="form-group">
                <label for="status"> Status</label>

                <select class="form-control" name="status" required>
                  <option value='1' @if($state->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                  <option value='0' @if($state->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
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