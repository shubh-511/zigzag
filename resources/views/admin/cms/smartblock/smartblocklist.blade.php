@extends('layouts.adminlay')
@section('content')
<aside class="right-side">                
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Smartblock List
     ({{ count($smartblocks)}})
   </h1>
   <ol class="breadcrumb">
     <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
     <li class="active">Smart Block</li>
   </ol>
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
         
         
         <form name="form2" id="form2" method="get" action="" class="form-horizontal">
          <table class="table table-advance" >
            <tr>
            <!--  <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
              <th><input type="text" placeholder="Enter Email" name="email" value=""></th>
              <th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
              <th><input type="hidden" name="search" value="search">
                <button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
              </th>
              -->
              <th><span style="float: right;">
               <a href="{{ url('admin/smartblockadd')}}" class="btn btn-default">Add Smart Block</a> 
               <a href="javascript:muldelete()" class="btn btn-default">Delete</a></span>
             </th>
           </tr>
         </table>
       </form>

       <!--  <h3 class="box-title">Menu List</h3>-->
                                 <!-- <div style="float:right"> 
									<a href="smartblock_add.php"><button class="btn btn-default">Add smartblock</button></a><a href="javascript:muldelete()"><button class="btn btn-default">Delete All</button></a>
                                    </div>
     <input type="text" id="search" name="search" class="form-control input-sm" placeholder="Search by name" style="width:20%"  onkeyup="smartblock_search(this.value)">
                              
                         <button type="submit" name="q" class="btn btn-sm btn-primary" style="display:inline"><i class="fa fa-search"></i></button>
                       -->
                     </div><!-- /.box-header -->
                     <form id="smartblock" name="smartblock" action="" method="post">
                       <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <tr>
                             <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>
                             <th>Name</th>
                             <th>Parent page</th>
                             <th>Status</th>
                             <th>Action</th>
                             
                           </tr>
                         </thead>
                         
                         <tbody id="rowbody">
                          @foreach($smartblocks as $smartblock)                          	
                          <tr>
                            <th scope="col">
                             <input type="checkbox" class="check_box" name="mul_del[]" id="mul_del[]" value="{{$smartblock->id}}" /></th>
                             
                             <td>{{ $smartblock->name}}</td>
                             <td>{{ $smartblock->pages->name}}</td>
                             <td>
                               <a href="javascript:" onclick="update_status('{{ $smartblock->id}}',{{abs($smartblock->status-1)}})">
                                <span class="label  @if($smartblock->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                                  @if($smartblock->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                                </span>
                              </a>
                            </td>       
                            <td>
                             <a title="Edit" href="{!! url('admin/smartblock/smartblockedit',[$smartblock->id]) !!}"><i class="fa fa-pencil"></i>
                             </a>  

                             <!--<a title="Delete" href="javascript:muldelete()"><i class="fa fa-trash-o"></i></a>-->
                           </td>
                         </tr>
                         @endforeach	
                       </tbody>
                       
                     </table>
                     {{$smartblocks->links()}}
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
         url: "../admin/updatesmartblockstatus",
         success: function(result){
           alert( 'Update Action Completed.');
           location.reload();
         }});
     }
     function muldelete()
     {
      element_lenght= smartblock.elements.length;
      for(i=0;i<element_lenght;i++)
      {
       if(smartblock.elements[i].name=="mul_del[]")
       {
        if(smartblock.elements[i].checked==true)
        {
         if(confirm("Are you sure delete record(s)?"))
         {
          $("#smartblock").attr("action", "{{url('admin/deleteallsmartblock')}}");
          
          this.smartblock.submit();
          break;
        }
      }	
    }
  }
}
function smartblock_search(val){
  if(val!=="")
  {
			//alert("hello");
			$.ajax({
				method: "POST",
				url: "../ajax.php",
				data: {act: "smartblock_search", s_result:val}
			})
			.done(function( msg ) {
       $("#rowbody").html('')
       $("#rowbody").append(msg)
     });
		}
		else{
			window.location.href='smartblock_list.php';
		}
	}
	

</script>