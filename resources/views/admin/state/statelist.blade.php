@extends('layouts.adminlay')
@section('content')

<aside class="right-side">                
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      State List
      ( {{ count($states)}} )
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">State</li>
    </ol>
    <h1 style="float:right; margin-top:-10px; color:#F00"> <?php if(isset($_REQUEST['msg']) && !empty($_REQUEST['msg'])) echo $_REQUEST['msg']; ?> </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header" >
            @if(Session::has('message')) <div class=" alert alert-success"> 
              <span class="glyphicon glyphicon-ok "></span><em> {!! session('message') !!}</em>
            </div>@endif


            <form name="form2" id="form2" method="get" action=""   class="form-horizontal">
              <table class="table table-advance" >
                <tr>
<!-- <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
<th><input type="text" placeholder="Enter Email" name="email" value=""></th>
<th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
<th><input type="hidden" name="search" value="search">
<button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
</th>
-->
<th><span style="float: right;">
  <a href="{{ url('admin/stateadd')}}" class="btn btn-default">Add State</a>
  <a href="javascript:muldelete()" class="btn btn-default">Delete </a></span>
</th>
</tr>
</table>
</form>
</div><!-- /.box-header -->
<form id="state" name="state" action="" method="post">
  <div class="box-body table-responsive">

    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>

          <th>State</th>
          
          
          <th>Country</th>
          <th>Status</th>
          <th colspan="2">Action</th>

        </tr>
      </thead>


      <tbody id="rowbody">
        @foreach($states as $state)
        <tr>
          <th scope="col">
            <input type="checkbox" class="check_box" name="mul_del[]" id="mul_del[]" value="{{ $state->id }}" /></th>

            <td>{{ $state->name }}</td>
            
            
            <td>{{$state->country->name}}</td>
            <td>
              <?php //echo abs($menu['status']-1);?>
              <a href="javascript:" onclick="update_status('{{ $state->id}}',{{abs($state->status-1)}})">
                <span class="label  @if($state->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                  @if($state->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                </span>
              </a>
            </td>

            <td><a title="Edit" href="{!! url('admin/state/stateedit',[$state->id]) !!}"><i class="fa fa-pencil"></i></a>

              <!--</td><td><a title="Delete" href="javascript:muldelete()"><i class="fa fa-trash-o"></i></a></td>-->
            </tr>
            @endforeach
          </tbody>


        </table>
        {{ $states->links()}}                   
      </div><!-- /.box-body -->
    </form>
  </div><!-- /.box -->
</div>
</div>

@stop


<script type="text/javascript">
  function isValid(formRef)
  {

    for(var i=0;i<formRef.elements.length;i++)
    {
      if(formRef.elements[i].type == "checkbox")
      {
        formRef.elements[i].checked = formRef.cb1.checked
      }
}//end of loop
}

function update_status(id,value)
{     
  $.ajax({
    type: 'GET',
    data: {'id':id,'value':value},
    url: "../admin/updatestatestatus",
    success: function(result){
      alert( 'Update Action Completed.');
      location.reload();

    }});
}  
function muldelete()
{
  element_lenght= state.elements.length;
  for(i=0;i<element_lenght;i++)
  {
    if(state.elements[i].name=="mul_del[]")
    {
      if(state.elements[i].checked==true)
      {
        if(confirm("Are you sure delete record(s)?"))
        {
          $("#state").attr("action", "{{url('admin/deleteallstate')}}");
          this.state.submit();
          break;
        }
      }	
    }
  }
}

</script>