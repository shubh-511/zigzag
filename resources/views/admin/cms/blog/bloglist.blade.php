@extends('layouts.adminlay')
@section('content')
<aside class="right-side">                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Blog List
            ({{ count($blogs)}})
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Blog</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              
                <div class="box">
                    <div class="box-header">

                        @if(Session::has('message')) 
                        <div class=" alert alert-success"> 
                           <span class="glyphicon glyphicon-ok "></span>
                           <em> {!! session('message') !!}</em>
                       </div>
                       @endif
                       <form name="form2" id="form2" method="get" action=""   class="form-horizontal">
                          <table class="table table-advance" >
                              <tr>
         <!-- <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
          <th><input type="text" placeholder="Enter Email" name="email" value=""></th>
      <th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
            <th><input type="hidden" name="search" value="search">
            <button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
        </th>-->
        <th><span style="float: right;">
          <a href="{{ url('admin/blogadd')}}" class="btn btn-default"> Add Blog</a>
          <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
      </th>
  </tr>
</table>
</form>
</div><!-- /.box-header -->

<form id="blog" name="blog" action="" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="box-body table-responsive">
    <table id="example1" class="table table-bordered table-striped">
        
        <thead>
            <tr>
                <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>
                <th>Title</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        
        
        <tbody id="rowbody">
            @foreach($blogs as $blog)
            <tr>
             <th scope="col"><input type="checkbox" name="mul_del[]"  value="{{ $blog->id }}" />
             </th>
             <td>{{ $blog->name }}</td>
             <td>
               <?php //echo abs($menu['status']-1);?>
               <a href="javascript:" onclick="update_status('{{ $blog->id}}',{{abs($blog->status-1)}})">
                <span class="label  @if($blog->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                    @if($blog->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                </span>
            </a>
        </td>

        
        
        <td>
            <a title="Edit" href="{!! url('admin/blog/blogedit',[$blog->id]) !!}"><i class="fa fa-edit"></i>
            </a> 
             <a title="Comments" href="{!! url('admin/comment',[$blog->id]) !!}"><i class="fa fa-comments-o"  aria-hidden="true"></i>
            </a>
            <a title="View Blog" href="{!! env('APP_URL').'news/'.$blog->slug !!}" target="_blank"><i class="fa fa-desktop"  aria-hidden="true"></i>
            </a>
        </td>
    </tr>
    @endforeach
</tbody> 



</table>
{{ $blogs->links()}}                              
</div><!-- /.box-body -->
</form>
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
      element_lenght= blog.elements.length;
      for(i=0;i<element_lenght;i++)
      {
         if(blog.elements[i].name=="mul_del[]")
         {
            if(blog.elements[i].checked==true)
            {
               if(confirm("Are you sure delete record(s)?"))
               {
                 $("#blog").attr("action", "{{url('admin/deleteallblog')}}");				
                 this.blog.submit();
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
       url: "../admin/updateblogstatus",
       success: function(result){
           alert( 'Update Action Completed.');
           location.reload();
       }});
}	

</script>