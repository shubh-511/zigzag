@extends('layouts.adminlay')
@section('content')

<aside class="right-side">                
    <!-- Content Header (banner header) -->
    <section class="content-header">
        <h1>
            Banner List
            ({{ count($banners)}})
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Banner</li>
        </ol>   
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <!--  <h3 class="box-title">Menu List</h3>-->
                        @if(Session::has('message')) <div class=" alert alert-success"> 
                            <span class="glyphicon glyphicon-ok "></span><em> {!! session('message') !!}</em>
                        </div>@endif


                        <form name="form2" id="form2" method="get" action="" class="form-horizontal">
                            <table class="table table-advance" >
                                <tr>
<!-- <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
<th><input type="text" placeholder="Enter Email" name="email" value=""></th>
<th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
<th><input type="hidden" name="search" value="search">
<button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
</th>-->
<th><span style="float: right;">
    <a href="{{ url('admin/banneradd')}}" class="btn btn-default">Add Banner</a> 
    <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
</th>
</tr>
</table>
</form>
</div><!-- /.box-header -->
<form id="banner" name="banner" action="" method="post">
    <div class="box-body table-responsive">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Page</th>
                    <th>Place</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="rowbody">
                @foreach($banners as $banner)
                <tr>
                    <th scope="col">
                        <input type="checkbox" class="check_box" name="mul_del[]" id="mul_del[]" value="{{ $banner->id }}" /></th>


                        <td>{{ $banner->name}}</td>
                        <td><img src="{!! asset($banner->file) !!}" height='80'></td>

                        <td> 
                            {{ $banner->pages['name']}}
                        </td>



                        <td>
                            @if($banner->placeholder=='1')
                            {{'Home'}}
                            @elseif($banner->placeholder=='2')
                            {{'Inner'}}
                            @elseif($banner->placeholder=='3')
                            {{'Page'}}
                            @elseif($banner->placeholder=='4')
                            {{'back'}}
                            @endif
                        </td>
                        <td>
                            <?php //echo abs($user['status']-1);?>
                            <a href="javascript:" onclick="update_status('{{ $banner->id}}',{{ abs($banner->status-1)}})">
                                <span class="label  @if($banner->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                                    @if($banner->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                                </span>
                            </a>
                        </td>

                        <td>
                            <a title="Edit" href="{!! url('admin/banner/banneredit',[$banner->id]) !!}"><i class="fa fa-pencil"></i>
                            </a>  
<!--   <a title="Delete" href="javascript:muldelete()"><i class="fa fa-trash-o"></i>
</a> -->
</td>
</tr>
@endforeach
</tbody>
</table>

</div><!-- /.box-body -->
</form>
{{$banners->links()}}
</div><!-- /.box -->
</div>
</div>
@stop



<script language="JavaScript">

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

function muldelete()
{
    element_lenght= banner.elements.length;
    for(i=0;i<element_lenght;i++)
    {
        if(banner.elements[i].name=="mul_del[]")
        {
            if(banner.elements[i].checked==true)
            {
                if(confirm("Are you sure delete record(s)?"))
                {
                    $("#banner").attr("action", "{{url('admin/deleteallbanner')}}");
                    this.banner.submit();
                    break;
                }
            }   
        }
    }
}
function update_status(id,value)
{     
    $.ajax({
        type: 'GET',
        data: {'id':id,'value':value},
        url: "../admin/updatebannerstatus",
        success: function(result){
            alert( 'Update Action Completed.');
            location.reload();
        }});
}   

</script>