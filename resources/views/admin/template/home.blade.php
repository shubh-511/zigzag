@extends('layouts.adminlay')
<?php //if(empty($_SESSION['user_email'])){ echo '<script>window.location.href="index.php" </script>'; } ?>
<!-- Right side column. Contains the navbar and content of the page -->
          @section('content')
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                     @if(Session::has('welcome_message')) 
                        <div class=" alert alert-success"> 
                          <span class="glyphicon glyphicon-ok "></span><em> {!! Session::get('welcome_message') !!}</em>
                        </div>
                    @endif  
                      
                    @if(Session::has('bu_user_info'))
                        @if(Session::get('bu_user_info')->roles_id==3)
                            @if(Session::get('bu_user_info')->status==0)
                            <div class="col-lg-12 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner text-center">
                                    <h3>
                                     <?php //echo $obj->getNewOrder(); ?>
                                    </h3>
                                     
                                    <p>
                                        
                                Hi, {{Session::get('bu_user_info')->name}}
                                <br>
                                Admin didn't verify your profile.    
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="" class="small-box-footer">
                                    <i class="fa fa-arrow-circle-right1"></i>
                                </a>
                            </div>
                            </div><!-- ./col -->
                            @else
                            <div class="col-lg-12 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner text-center">
                                    <h3>
                                     <?php //echo $obj->getNewOrder(); ?>
                                    </h3>
                                    <p>
                                        No information available.    
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="" class="small-box-footer">
                                    <i class="fa fa-arrow-circle-right1"></i>
                                </a>
                            </div>
                            </div><!-- ./col -->
                            @endif
                            
                        @elseif(Session::get('bu_user_info')->roles_id==1)
						<div style="Text-align:center;">
					 <img src="{{ url('siteimages/site/logo.png')}}" width="300px"> 
					
					<h2>Welcome Back, Administrator  </h2></div>
                       
                            @endif
                        
                    @endif
                    </div><!-- /.row -->
    
@stop