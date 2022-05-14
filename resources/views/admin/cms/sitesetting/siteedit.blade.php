@extends('layouts.adminlay')
@section('content')


<aside class="right-side">
  <section class="content-header"> 
    <h1>Site Settings</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Site Setting</li>
    </ol>
  </section>
  
  <section class="content">
   <div class="row">
    <div class="col-md-12">
     <div class="box box-primary">

      <div class="box-header"> 

      </div><!-- /.box-header -->
                 <?php //print_r($siteInfo->id); 
                 /**/?>

                 <form role="form" action="{{ url('admin/editsite')}}" method="post" enctype="multipart/form-data"> 
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Site Title'}}</label>
                      <input type="text" class="form-control" id="site_name" name="site_name" required value="{{$sitedata->site_name}}">
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Floating Text'}}</label>
                      <input type="text" class="form-control" id="floating_text" name="floating_text" required value="{{$sitedata->floating_text}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Header Logo'}}</label>
                      <input type="file"  class="form-control" name="header_logo"/>
                      <input type="hidden" name="header" value="{{$sitedata->header_logo}}">
                      <img src="{!! asset($sitedata->header_logo)!!}" alt="header logo" height="80px" id="site_logo"/>
                    </div>

                    
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Site Contact Us Email'}}</label>
                      <input type="text" class="form-control" id="email1" name="site_email1"  value="{{$sitedata->site_email1}}">
                    </div>  

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Address'}}</label>
                      <input type="text" class="form-control" id="site_address" name="site_address"  required value="{{$sitedata->site_address}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Contact no.'}}</label>
                      <input type="text" class="form-control" id="site_contact_no" name="site_contact_no"  value="{{$sitedata->site_mobile}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Site Email'}}</label>
                      <input type="text" class="form-control" id="site_email2" name="site_email2"  value="{{$sitedata->site_email2}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Facebook Link'}}</label>
                      <input type="text" class="form-control" id="site_fb_link" name="fb_link"   value="{{$sitedata->fb_link}}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Twitter Link'}}</label>
                      <input type="text" class="form-control" id="site_twitter_link" name="twitter_link"  value="{{$sitedata->twitter_link}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Youtube Link'}}</label>
                      <input type="text" class="form-control" id="site_youtube_link" name="youtube_link" value="{{$sitedata->youtube_link}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Pinterest Link'}}</label>
                      <input type="text" class="form-control" id="site_pin_link" name="pin_link" value="{{$sitedata->pin_link}}">
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Google Link'}}</label>
                      <input type="text" class="form-control" id="site_google_link" name="google_link" value="{{$sitedata->google_link}}">
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Instagram link'}}</label>
                      <input type="text" class="form-control" id="site_instagram_link" name="instagram_link" value="{{$sitedata->instagram_link}}">
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Dribbble link'}}</label>
                      <input type="text" class="form-control" id="site_dribbble_link" name="dribbble_link" value="{{$sitedata->dribbble_link}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Linkedin Link'}}</label>
                      <input type="text" class="form-control" id="site_linkedin_link" name="linkedin_link"  value="{{$sitedata->linkedin_link}}">
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Apple Store App Link'}}</label>
                      <input type="text" class="form-control" id="site_apple_link" name="apple_link"  value="{{$sitedata->apple_link}}">
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Play Store App Link'}}</label>
                      <input type="text" class="form-control" id="site_playstore_link" name="playstore_link"  value="{{$sitedata->playstore_link}}">
                    </div>
                    
                    
                    

                    <div class="form-group">
                      <label for="exampleInputEmail">{{'Copy Rights Link'}}</label>
                      <input type="text" class="form-control" id="site_copy_rights" name="copyrights" value="{{$sitedata->copy_right}}">
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </form>

              </div>
            </div><!-- /.box-body -->
          </div>    
        </section>
      </aside>
      @stop