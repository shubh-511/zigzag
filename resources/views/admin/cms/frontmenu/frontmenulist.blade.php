@extends('layouts.adminlay')
@section('content')


<aside class="right-side">                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Front Menus
            ({{ count($frontmenus)}})   
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Front Menu</li>
        </ol>
        
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              
                <div class="box">
                    <div class="box-header">
                       @if(Session::has('message')) <div class=" alert alert-success"> 
                         <span class="glyphicon glyphicon-ok "></span><em> {!! session('message') !!}</em>
                     </div>@endif

    <?php /*

    @if(Session::has('message')) <div class=" alert alert-success"> 
   <span class="glyphicon glyphicon-ok "></span><em> {!! session('message') !!}</em>
</div>@endif
  
  <form name="form2" id="form2" method="get" action=""   class="form-horizontal">
          <table class="table table-advance" >
      <tr>
        <th ><input type="text" placeholder="Enter Name" name="first_name" value=""></th> 
          <th><input type="text" placeholder="Enter Email" name="email" value=""></th>
      <th><input type="text" placeholder="Enter Mobile" name="mobile" value=""></th>
            <th><input type="hidden" name="search" value="search">
            <button type="submit"  class="btn btn-sm btn-medium" ><i class="fa fa-search"></i></button>
            </th>
            <th><span style="float: right;">
              <a href="{{url('admin/frontmenuadd')}}" class="btn btn-default">Add Front Menu</a>
              <a href="javascript:muldelete()" class="btn btn-default">Delete </a></span>
            </th>
    </tr>
      </table>
    </form>

    */
    ?>
    <!--  <h3 class="box-title">Menu List</h3>-->
    <div  style="float:right">
        <!--<a href="frontmenu_add.php"><button class="btn btn-default">Add Menu Category </button></a>-->
    </div>
    <!--<input type="text" id="search" autofocus name="search" class="form-control input-sm" placeholder="Search by name or degination" style="width:20%"  onkeyup="category_search(this.value)">-->
    
    <!--<button type="submit" name="q" class="btn btn-sm btn-primary" style="display:inline"><i class="fa fa-search"></i></button>-->
    
</div><!-- /.box-header -->
<form id="front_menu" name="front_menu" action="" method="post">
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" name="cb1" value="1" onClick="isValid(this.form)">All</th>
                    <th>Name</th>
                    <th>Status</th>                         <th>Action</th>
                </tr>
            </thead>
            <tbody id="rowbody">
                @foreach($frontmenus as $frontmenu)              
                <tr>
                    <th scope="col">
                        <input type="checkbox" name="mul_del[]" id="mul_del[]" value="{{ $frontmenu->id }}" />
                    </th>
                    
                    <td>{{ $frontmenu->name}}</td>
                    <td>
                        <a href="javascript:" onclick="update_status('{{ $frontmenu->id}}',{{abs($frontmenu->status-1)}})">
                            <span class="label  @if($frontmenu->status!='0') {{'label-success'}} @else {{'label-warning'}} @endif">
                                @if($frontmenu->status=='1') {{'Active'}} @else {{'Inactive'}} @endif 
                            </span>
                        </a>
                    </td> 
                    
                    <td><a title="Edit" href="{!! url('admin/frontmenu/frontmenuedit',[$frontmenu->id]) !!}"><i class="fa fa-pencil"></i></a></td>
                </tr>
                @endforeach                    
            </tbody>
        </table>            
        {{ $frontmenus->links()}}
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
            url: "../admin/updatefrontmenustatus",
            success: function(result){
                alert( 'Update Action Completed.');
                location.reload();
            }});
    }

    function muldelete()
    {
        element_lenght= front_menu.elements.length;
        for(i=0;i<element_lenght;i++)
        {
            if(front_menu.elements[i].name=="mul_del[]")
            {
                if(front_menu.elements[i].checked==true)
                {
                    if(confirm("Are you sure delete record(s)?"))
                    {
                        $("#front_menu").attr("action", "{{url('admin/deleteallfrontmenu')}}");
                        this.front_menu.submit();
                        break;
                    }
                }   
            }
        }
    }
    
</script>