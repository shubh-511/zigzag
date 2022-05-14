    @extends('layouts.adminlay')
    @section('content')
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Page
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{ url('admin/pages')}}">Pages</a></li>
                <li class="active">Edit Page</li>
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
                        <form role="form" action="{{ url('admin/editpage',[$epage->id])}}" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{$epage->name}}">
                                </div>
            <!--
                 <div class="form-group">
                <label for="exampleInputEmail1">Heading for Top Banner</label>
                <input type="text"  class="form-control" id="heading" name="heading" placeholder="Heading for top banner" required value="{{ $epage->heading}}">
                </div>
            -->
            
            <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="Parent Menu"> Parent Page</label>
                <select class="form-control" name="parent_id">
                    <option value='0'>--Select Parent--</option>
                    @foreach($pages as $page)
                    <option value="{{ $page->id}}" @if($epage->parent_id==$page->id) {{ 'selected="true"'}} @endif>{{ $page->name}}</option>
                    @endforeach 	
                </select> 
            </div>

                <!--<div class="form-group">
                <label for="exampleInputEmail1">Heading</label>
                <input type="text" class="form-control" id="heading" name="heading" placeholder="Heading"  value="">
            </div>-->
            <ul class="nav nav-tabs faq-page">
             <li class="active"><a data-toggle="tab" href="#menu1">Short Description</a></li>
             <li><a data-toggle="tab" href="#menu2">Description</a></li>
         </ul>

         <div class="tab-content">    
             <div id="menu1" class="tab-pane fade in active">
                <div class="form-group">
                 <textarea class="ckeditor"  id="short_description" name="short_description" >{{ $epage->short_description}}</textarea>
             </div>
             
             <div class="form-group">
                <label for="exampleInputEmail1">Short Description Image</label>

                <input type="file" class="form-control" id="short_des_image" name="short_des_image" placeholder="Image">

                <input type="hidden" name="fshort_des_image" value="{{ $epage->short_des_image}}">
                
                <img src="{!! asset($epage->short_des_image)!!}" height='80' alt="short description image">
            </div>
        </div>
        
        <div id="menu2" class="tab-pane fade">
         <div class="form-group">
            <textarea class="ckeditor"  id="long_description" name="long_description" >{{ $epage->long_description}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Description Image</label>
            <input type="file" class="form-control" id="des_image" name="des_image" placeholder="Image">
            <input type="hidden" name="fdes_image" value="{{ $epage->des_image}}">
            <img src="{!! asset($epage->des_image)!!}" height='80' alt="description image">
        </div>
    </div>
</div>



                <!--<div class="form-group">
                <label for="exampleInputEmail1">Sub Description</label>
                <textarea class="ckeditor"  id="sub_description" name="sub_description" > </textarea>
            </div>-->
             <!--   <div class="form-group">
                <label for="exampleInputEmail1">Feature Image</label>
                <input type="hidden" name="fimage" value="{{$epage->image}}">
                <input type="file" class="form-control" id="image" name="image" placeholder="Image">
                <img src="{!! asset($epage->image)!!}" height='80' alt="feature image">
                             
                </div>

            -->
            
            <ul class="nav nav-tabs faq-page">
               <li class="active"><a data-toggle="tab" href="#menu3">Meta Title</a></li>
               <li><a data-toggle="tab" href="#menu4">Meta Keyword</a></li>
               <li><a data-toggle="tab" href="#menu5">Meta Description</a></li>
           </ul>

           <div class="tab-content"> 

             <div id="menu3" class="tab-pane fade in active">
                <div class="form-group">
                	
                	<textarea class="form-control" id="metatitle" name="metatitle" >{{ $epage->metatitle}}</textarea>
                </div>
            </div>

            <div id="menu4" class="tab-pane fade">
                <div class="form-group">
                	
                	<textarea class="form-control" id="metakeyword" name="metakeyword" >{{ $epage->metakeyword}}</textarea>
                </div>
            </div>

            <div  id="menu5" class="tab-pane fade">
                <div class="form-group">
                    
                    <textarea class="form-control" id="metadescription" name="metadescription" >{{ $epage->metadescription}}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="status"> Status</label>
            
            <select class="form-control" name="status" required>
                <option value=''>--Select Status--</option>
                <option value='1' @if($epage->status=='1') {{ 'selected="true"'}} @endif>Active</option>
                <option value='0' @if($epage->status=='0') {{ 'selected="true"'}} @endif>Inactive</option>
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
</section>
</aside>
@stop