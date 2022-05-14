@extends('layouts.adminlay')
@section('content')

<?php //echo '<pre>';print_r($roles);
  /*$smenus='';
  $m=array();
  $s=array();
  $mains=$subs=array();

if(Session::has('mains'))
  {
    $smenus=Session::get('mains');
    $m=$smenus->menu_id;
    $s=$smenus->child_menu_id;
    $mains=explode(",",$m);
    $subs=explode(",",$s);
  } 
*/
  $menupage=$frontmenu->page_id;
  $mpage=explode(",",$menupage);


  
  ?>


  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Front Menu    
            <!--<small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/frontmenu')}}">Front Menu</a></li>
            <li class="active">Edit Front Menu</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <!-- <h3 class="box-title">Create Menu</h3>-->
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('admin/editfrontmenu',[$frontmenu->id])}}" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{ $frontmenu->name}}">
                                
                            </div>
                            
                            <?php
                /*
                $rows = $obj->getTable('emp_pages','id');
$totalrow = count($rows);
if($totalrow>0) {
    echo "<label >Select Pages to Display under this Category</label></br>";
    for($i=0; $i<$totalrow; $i++){
        if($rows[$i]['parent_id']=='0' && $rows[$i]['id'] !='6' ){ ?>

                
                <label for="checkbox"> <input type="checkbox" class="form-control" id="name" name="privilege[]" value="<?php echo $rows[$i]['id'];?>"<?php if(!empty($_REQUEST['edit'])){
                    if(in_array($rows[$i]['id'], $u_privilege)) echo "checked";} ?>>
                    <strong><?php echo $rows[$i]['name']; ?></strong> </label> </br>
                
    
    <?php 


}}}

*/?>



<label >Select Pages to Display under this Category</label><br> 
@foreach($pages as $page) 
<label for="checkbox"> 
    <input style="float:left; width:auto; margin-right:10px; height:auto;" type="checkbox" class="form-control" id="name" name="privilege[]" value="{{ $page->id }}" @if(in_array($page->id,$mpage)) {{'checked' }} @endif>
    
    <strong style="float:left; width:auto;" >{{ $page->name}}</strong> 

</label> </br>
@endforeach
<div class="form-group">
    <label for="status"> Status</label>

    <select class="form-control" name="status" required>
        
        <option value='1' @if($frontmenu->status=='1') {{'selected="true"'}} @endif>Active</option>
        <option value='0'@if($frontmenu->status=='0') {{'selected="true"'}} @endif>Inactive</option>
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