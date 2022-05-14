<?php
//include('../lib/config.php');

	/*global $site_map;

	$obj->initSite();

	//print_r($_SESSION);

	$actionlist=array("1"=>"Add", "2"=>"Edit", "3"=>"Delete");

	if(!empty($_SESSION['action']))

	{

	$action_menu= explode(',',$_SESSION['action']);

	}

	*/
?>

<!DOCTYPE html>

<html>

    <head>

    

        <meta charset="UTF-8">

        <title>Zig-Zag | Dashboard</title>

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- bootstrap 3.0.2 -->
        <script src="{!! asset('ckeditor/ckeditor.js') !!}"></script>
        <link href="{{ asset('public/admincss/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{!! asset('siteimages/site/logo.png') !!}">

<link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- font Awesome -->

        <link href="{{ asset('public/admincss/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->

       <!-- <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />-->

        @stack('multi_select')
        <!-- Morris chart -->

        <link href="{{ asset('public/admincss/morris/morris.css') }}" rel="stylesheet" type="text/css" />

        <!-- jvectormap -->

        <link href="{{ asset('public/admincss/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

        <!-- fullCalendar -->

        <link href="{{ asset('public/admincss/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css" />

        <!-- Daterange picker -->

        <link href="{{ asset('public/admincss/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />

        <!-- bootstrap wysihtml5 - text editor -->

        <link href="{{ asset('public/admincss/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Theme style -->

        <link href="{{ asset('public/admincss/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

       <link href="{{ asset('public/admincss/style.css') }}" rel="stylesheet" type="text/css"/>


      <style>
          /*----------------------------------------------------*/
.field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}

.container{
  padding-top:50px;
  margin: auto;
}
          
      </style>

   <style>
        .goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {
    top: 0px !important; 
    }
    
    .goog-te-banner-frame{visibility:hidden !important;}
#body-main{top:0px !important;}
.goog-logo-link {
    display:none;
}
    </style>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoRFSrVXzCz2alS06R47o0yuO0MNHGMH0&libraries=places"></script>
   
      <!------------------Google Address Apis-------------------------->
 <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', function () {
   
            var places = new google.maps.places.Autocomplete(document.getElementById('address'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
               // var mesg = "Address: " + address;
                //mesg += "\nLatitude: " + latitude;
                //mesg += "\nLongitude: " + longitude;
               //alert(mesg);
      document.getElementById('latitude').value=latitude;
      document.getElementById('longitude').value=longitude;
    });
        });
    </script>
    
    </head>

    <body class="skin-black">

        <!-- header logo: style can be found in header.less -->

        <header class="header">

           <a href="" style="
    /* background: #757576; */
    border-bottom: 1px solid #f9f9f9;
"
" class="logo">
       
                <!-- Add the class icon to your logo image or logo icon to add the margining -->

           <h4 style="font-size: 15px;
    margin-top: 15px;
    font-weight: 900;">Zig-Zag</h4>

            </a>

            <!-- Header Navbar: style can be found in header.less -->

            <nav class="navbar navbar-static-top" user="navigation">

                <!-- Sidebar toggle button-->

                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" user="button">

                    <span class="sr-only">Toggle navigation</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </a>

                <div class="navbar-right">

                    <ul class="nav navbar-nav">

                      

                        </li>

                      

                        <li class="dropdown user user-menu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                                <i class="glyphicon glyphicon-user"></i>

                                <span> @if(Session::has('username'))             
                                            {{ Session::get('username')}}
                                            @endif<?php //if(!empty($_SESSION))echo $_SESSION['username']?><i class="caret"></i></span>

                            </a>

                            <ul class="dropdown-menu">

                                <!-- User image -->

                             

                                <!-- Menu Body -->

                               

                                <!-- Menu Footer-->

                                <li class="user-footer">

                                    <div class="pull-left">

                                        <a href="{{ url('admin/profile')}}" class="btn btn-default btn-flat">Profile</a>

                                    </div>

                                    <div class="pull-right">

                                        @if(Session::has('bu_user_info'))             
                                            <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        @endif

                                    </div>

                                </li>

                            </ul>

                        </li>

                    </ul>

                </div>

            </nav>

        </header>

		  <div class="wrapper row-offcanvas row-offcanvas-left">