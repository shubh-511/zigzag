@extends('layouts.adminlay')
@section('content')
<aside class="right-side">
   <section class="content-header">
      <h1>Document Upload</h1>
        <ol class="breadcrumb">
          <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li>User</li> 
          <li class="active">Document Upload</li>
        </ol> 
    </section>
    <section class="content">
       <div class="row">
        <div class="col-md-12">
           <div class="box box-primary">
                <div class="box-header"> 
                     @foreach ($errors->all() as $error)
                          <div class=" alert alert-danger">
                             <span class="glyphicon glyphicon-remove"></span>{{ $error }}
                           </div>
                     @endforeach

                  </div><!-- /.box-header -->
                 <form role="form" action="{{ url('admin/save_document')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="box-body">
                <div class="col-md-6">            
                <div class="form-group">
					<label for="exampleInputEmail">Social Security Card</label>
					<input style="padding:0;" type="file" class="form-control" name="ssc_image"  required >
				</div>
				<div class="form-group">
      				<label for="exampleInputEmail">Document Number</label>
					<input type="text" class="form-control" name="ssc_doc_no"  @if(!empty($docs->ssc_doc_no)) value="{{$docs->ssc_doc_no}}" @endif  required>
    			</div>
    			<div class="form-group">
      				<label for="exampleInputEmail">Expire Date</label>
      				<input type="date" class="form-control" name="ssc_exp_date" @if(!empty($docs->ssc_exp_date)) value="{{$docs->ssc_exp_date}}" @endif required>
                </div>
				</div>
				
				<div class="col-md-6">
    			<div class="form-group">
    			@if(!empty($docs))
    		    <img src="{{asset($docs->ssc_image)}}" height="205" width="210" style="margin-top:25px">@endif
    			@if(!empty($docs->ssc_image))	<span><a title="Download Social Security Card" href="{{asset($docs->ssc_image)}}" class="fa fa-download" download style="margin-left:10px; font-size:30px"></a></span>@endif
    			</div>
    		    </div>
		   
                
                <div class="col-md-12">
                <div class="box-footer" style="float:right">
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="type" value="ssc">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                </div>
            </div>
             
            
            </form>
            
            
    <!--================== Insuranse ====================--->
      <form role="form" action="{{ url('admin/save_document')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                <div class="col-md-6">            
                <div class="form-group">
					<label for="exampleInputEmail">Insurance Certificate</label>
					<input style="padding:0;" type="file" class="form-control" name="insurance_image"  required >
				</div>
				<div class="form-group">
      				<label for="exampleInputEmail">Document Number</label>
					<input type="text" class="form-control" name="insurance_doc_no" @if(!empty($docs->insurance_doc_no)) value="{{$docs->insurance_doc_no}}" @endif required >
    			</div>
    			<div class="form-group">
      				<label for="exampleInputEmail">Expire Date</label>
      				<input type="date" class="form-control" name="insurance_exp_date" @if(!empty($docs->insurance_exp_date)) value="{{$docs->insurance_exp_date}}" @endif required>
                </div>
				</div>
				
				<div class="col-md-6">
    			<div class="form-group">
    			@if(!empty($docs))	<img src="{{asset($docs->insurance_image)}}" height="205" width="210" style="margin-top:25px">@endif
    			    @if(!empty($docs->insurance_image))<span><a title="Download Social Security Card" href="{{asset($docs->insurance_image)}}" class="fa fa-download" download style="margin-left:10px; font-size:30px"></a></span>@endif
    			</div>
    		    </div>
		            
                <div class="col-md-12">
                <div class="box-footer" style="float:right">
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="type" value="insurance">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                </div>
            </div>
             
            
            </form>
            
    <!--================== State Issued Driver's License/ ID ====================--->
        <form role="form" action="{{ url('admin/save_document')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                <div class="col-md-6">            
                <div class="form-group">
					<label for="exampleInputEmail">State Issued Driver's License/ ID</label>
					<input style="padding:0;" type="file" class="form-control" name="dl_image"  required >
				</div>
				<div class="form-group">
      				<label for="exampleInputEmail">Document Number</label>
					<input type="text" class="form-control" name="dl_doc_no" @if(!empty($docs->dl_doc_no)) value="{{$docs->dl_doc_no}}" @endif  required >
    			</div>
    			<div class="form-group">
      				<label for="exampleInputEmail">Expire Date</label>
      				<input type="date" class="form-control" name="dl_exp_date" @if(!empty($docs->dl_exp_date)) value="{{$docs->dl_exp_date}}" @endif required>
                </div>
				</div>
				
				<div class="col-md-6">
    			<div class="form-group">
    				@if(!empty($docs))<img src="{{asset($docs->dl_image)}}" height="205" width="210" style="margin-top:25px">@endif
    				@if(!empty($docs->dl_image))<span><a title="Download Social Security Card" href="{{asset($docs->dl_image)}}" class="fa fa-download" download style="margin-left:10px; font-size:30px"></a></span> @endif
    			</div>
    		    </div>
		   
                
                <div class="col-md-12">
                <div class="box-footer" style="float:right">
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="type" value="dl">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                </div>
            </div>
             
            
            </form>
            
        
    <!--================== Police Clearance Certificate ====================--->
            <form role="form" action="{{ url('admin/save_document')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                <div class="col-md-6">            
                <div class="form-group">
					<label for="exampleInputEmail">Police Clearance Certificate</label>
					<input style="padding:0;" type="file" class="form-control" name="pcc_image"  required >
				</div>
				<div class="form-group">
      				<label for="exampleInputEmail">Issue Date</label>
      				<input type="date" class="form-control" name="pcc_issue_date" @if(!empty($docs->pcc_issue_date)) value="{{$docs->pcc_issue_date}}" @endif required>
                </div>
				<!--<div class="form-group">
      				<label for="exampleInputEmail">Document Number</label>
					<input type="text" class="form-control" name="ssc_doc_no"  required >
    			</div>
    			-->
				</div>
				
				<div class="col-md-6">
    			<div class="form-group">
    				@if(!empty($docs))<img src="{{asset($docs->pcc_image)}}" height="205" width="210" style="margin-top:25px"> @endif 
    			@if(!empty($docs->pcc_image))	<span><a title="Download Social Security Card" href="{{asset($docs->pcc_image)}}" class="fa fa-download" download style="margin-left:10px; font-size:30px"></a></span>@endif
    			</div>
    		    </div>
		   
                
                <div class="col-md-12">
                <div class="box-footer" style="float:right">
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="type" value="pcc">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                </div>
            </div>
             
            
            </form>
            
    <div class="clearfix"></div>
        </div><!-- /.box -->

        <!-- Form Element sizes -->
    </div>
</div>
</div>
@stop

