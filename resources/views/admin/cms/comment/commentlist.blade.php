@extends('layouts.adminlay')
@section('content')

<aside class="right-side">                
    <!-- Content Header (banner header) -->
    <section class="content-header">
        <h1>
            Comments List
            ({{ count($comments)}})
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Comment</li>
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
          <!--<a href="{{ url('admin/add')}}" class="btn btn-default">Add Banner</a>-->
          <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
      </th>
  </tr>
</table>
</form>
</div><!-- /.box-header -->
<form id="comment" name="comment" action="" method="post">
    <div class="box-body table-responsive">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>
                    <th>Blog</th>
                    <th>Sender</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody id="rowbody">
                @foreach($comments as $comment)
                <tr>
                   <th scope="col">
                      <input type="checkbox" class="check_box" name="mul_del[]" id="mul_del[]" value="{{ $comment->id }}" /></th>


                      <td>{{ $comment->blogs['name'] }}</td>
                      <td>
                        {{$comment->author_name}}
                    </td>
                    <td>
                        {!! $comment->content !!}
                    </td>
                    <td>
                        {!! date("jS M, Y",strtotime($comment->created_at)) !!}
                    </td>
                    
                    <td>
                        <?php //echo abs($user['status']-1);?>
                        <a href="javascript:" onclick="update_status('{{ $comment->id}}',{{ abs($comment->status-1)}})">
                            <span class="label  @if($comment->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                                @if($comment->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                            </span>
                        </a>
                    </td>
                    
                    <td>
                        <a title="Edit" href="{!! url('admin/comment/commentedit',[$comment->id]) !!}"><i class="fa fa-pencil"></i>
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
        element_lenght= comment.elements.length;
        for(i=0;i<element_lenght;i++)
        {
            if(comment.elements[i].name=="mul_del[]")
            {
                if(comment.elements[i].checked==true)
                {
                    if(confirm("Are you sure delete record(s)?"))
                    {
                        $("#comment").attr("action", "{{url('admin/deleteallcomment')}}");
                        this.comment.submit();
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
            url: "../admin/updatecommentstatus",
            success: function(result){
                alert( 'Update Action Completed.');
                location.reload();
            }});
    }   

</script>