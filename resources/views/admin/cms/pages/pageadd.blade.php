@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create Page
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('admin/pages')}}">Pages</a></li>
      <li class="active">Add Page</li>
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
            @foreach ($errors->all() as $error)
            <div class=" alert alert-danger">
             <span class="glyphicon glyphicon-remove"></span>{{ $error }}
           </div>
           @endforeach
         </div><!-- /.box-header -->
         <!-- form start -->
         <form role="form" action="{{ url('admin/savepage')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text"  class="form-control" id="name" name="name" placeholder="Name" required value="">
            </div>

             <!--   <div class="form-group">
                <label for="exampleInputEmail1">Heading for Top Banner</label>
                <input type="text"  class="form-control" id="heading" name="heading" placeholder="Heading for top banner" required value="">
                </div>
              -->
              
              <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="Parent Menu"> Parent Page</label>
                <select class="form-control" name="parent_id">
                  <option value='0'>--Select Parent--</option>
                  @foreach($pages as $page)
                  <option value="{{ $page->id }}">{{$page->name}}</option>
                  @endforeach 	
                </select> 
              </div>

                <!--<div class="form-group">
                <label for="exampleInputEmail1">Heading</label>
                <input type="text" class="form-control" id="heading" name="heading" placeholder="Heading"  value="<?= isset($row)? $row['heading'] : ''?>">
              </div>-->
              <ul class="nav nav-tabs faq-page">
               <li class="active"><a data-toggle="tab" href="#menu1">Short Description</a></li>
               <li><a data-toggle="tab" href="#menu2">Description</a></li>
             </ul>

             <div class="tab-content">    
              <div id="menu1" class="tab-pane fade in active">
               <div class="form-group">
                <textarea class="ckeditor"  id="short_description" name="short_description" ></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Short Description Image</label>
                <input type="file" class="form-control" id="short_des_image" name="short_des_image" placeholder="Image">
                <input type="hidden" name="short_des_image">
              </div>
            </div>
            
            <div id="menu2" class="tab-pane fade">
              <div class="form-group">
               <textarea class="ckeditor"  id="long_description" name="long_description" ></textarea>
             </div>
             <div class="form-group">
              <label for="exampleInputEmail1">Description Image</label>
              <input type="file" class="form-control" id="des_image" name="des_image" placeholder="Image">
              <input type="hidden" name="des_image">
            </div>
          </div>
        </div>


        
                <!--<div class="form-group">
                <label for="exampleInputEmail1">Sub Description</label>
                <textarea class="ckeditor"  id="sub_description" name="sub_description" > </textarea>
              </div>-->
              

              
              
              <ul class="nav nav-tabs faq-page">
               <li class="active"><a data-toggle="tab" href="#menu3">Meta Title</a></li>
               <li><a data-toggle="tab" href="#menu4">Meta Keyword</a></li>
               <li><a data-toggle="tab" href="#menu5">Meta Description</a></li>
             </ul>

             <div class="tab-content"> 

               <div id="menu3" class="tab-pane fade in active">
                <div class="form-group">
                	
                	<textarea class="form-control" id="metatitle" name="metatitle" ></textarea>
                </div>
              </div>

              <div id="menu4" class="tab-pane fade">
                <div class="form-group">
                	
                	<textarea class="form-control" id="metakeyword" name="metakeyword" ></textarea>
                </div>
              </div>

              <div  id="menu5" class="tab-pane fade">
                <div class="form-group">
                  
                  <textarea class="form-control" id="metadescription" name="metadescription" ></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="status"> Status</label>
              
              <select class="form-control" name="status" required>
                <option value=''>--Select Status--</option>
                <option value='1'>Active</option>
                <option value='0'>Inactive</option>
              </select> 
            </div>
          </div>
          <!-- /.box-body -->
          
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