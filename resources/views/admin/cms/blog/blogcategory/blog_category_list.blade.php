    @extends('layouts.adminlay')
    @section('content')
    <aside class="right-side">                
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Blog Categories
                ({{ count($bcategories)}})
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Blog Category</li>
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
          <a href="{{ url('admin/blog_category_add')}}" class="btn btn-default"> Add Blog Category</a>
          <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
      </th>
  </tr>
</table>
</form>
</div><!-- /.box-header -->

<form id="bcat" name="bcat" action="" method="post">
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
            @foreach($bcategories as $bcat)
            <tr>
             <th scope="col"><input type="checkbox" name="mul_del[]"  value="{{ $bcat->id }}" />
             </th>
             <td>{{ $bcat->name }}</td>
             <td>
               <?php //echo abs($menu['status']-1);?>
               <a href="javascript:" onclick="update_status('{{ $bcat->id}}',{{abs($bcat->status-1)}})">
                <span class="label  @if($bcat->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                    @if($bcat->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                </span>
            </a>
        </td>

        
        
        <td>
            <a title="Edit" href="{!! url('admin/blog-category/blog_category_edit',[$bcat->id]) !!}"><i class="fa fa-pencil"></i>
            </a> 
        </td>
    </tr>
    @endforeach
</tbody> 



</table>
{{ $bcategories->links()}}                              
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
      element_lenght= bcat.elements.length;
      for(i=0;i<element_lenght;i++)
      {
         if(bcat.elements[i].name=="mul_del[]")
         {
            if(bcat.elements[i].checked==true)
            {
               if(confirm("Are you sure delete record(s)?"))
               {
                 $("#bcat").attr("action", "{{url('admin/deleteallbcat')}}");				
                 this.bcat.submit();
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
       url: "../admin/updatebcatstatus",
       success: function(result){
           alert( 'Update Action Completed.');
           location.reload();
       }});
}	

</script>