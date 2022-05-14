<?php
include('../lib/config.php');

	//global $site_map;

	$obj->initSite();

	print_r($_SESSION); die;

	$actionlist=array("1"=>"Add", "2"=>"Edit", "3"=>"Delete");

	if(!empty($_SESSION['action']))

	{

	$action_menu= explode(',',$_SESSION['action']);

	}

	
?>

<!DOCTYPE html>

<html>

    <head>

    

        <meta charset="UTF-8">

        <title><?php echo $_SESSION['site_title']; ?>| Dashboard</title>

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- bootstrap 3.0.2 -->

        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- font Awesome -->

        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <!-- Ionicons -->

       <!-- <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />-->

        <!-- Morris chart -->

        <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />

        <!-- jvectormap -->

        <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

        <!-- fullCalendar -->

        <link href="../css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />

        <!-- Daterange picker -->

        <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

        <!-- bootstrap wysihtml5 - text editor -->

        <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

        <!-- Theme style -->

        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <link href="../css/style.css" rel="stylesheet" type="text/css"/>



      

    </head>

    <body class="skin-black">

        <!-- header logo: style can be found in header.less -->

        <header class="header">

           <a href="" class="logo">

                <!-- Add the class icon to your logo image or logo icon to add the margining -->

           <?php echo $_SESSION['site_title']; ?>

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

                                <span><?php if(!empty($_SESSION))echo $_SESSION['username']?><i class="caret"></i></span>

                            </a>

                            <ul class="dropdown-menu">

                                <!-- User image -->

                                <li class="user-header bg-light-blue">

                                <?php if(!empty($_SESSION))echo "<img src='../upload/$_SESSION[user_image]' class='img-circle' alt='User Image'>"; ?>

                                   <!-- <img src="../upload/<?php //echo $_SEESSION['user_image'] ?>" class="img-circle" alt="User Image" />-->

                                    <p>

                                        <?php if(!empty($_SESSION)) echo $_SESSION['username']?>

                                        

                                    </p>

                                </li>

                                <!-- Menu Body -->

                               

                                <!-- Menu Footer-->

                                <li class="user-footer">

                                    <div class="pull-left">

                                        <a href="../template/user_profile.php" class="btn btn-default btn-flat">Profile</a>

                                    </div>

                                    <div class="pull-right">

                                        <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>

                                    </div>

                                </li>

                            </ul>

                        </li>

                    </ul>

                </div>

            </nav>

        </header>

		  <div class="wrapper row-offcanvas row-offcanvas-left">