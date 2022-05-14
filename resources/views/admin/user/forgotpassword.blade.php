<!DOCTYPE html>
<html class="bg-black">
   <head>
        <meta charset="UTF-8">
        <title>Zig-Zag | Forgot Password</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{!! asset('public/admincss/bootstrap.min.css')!!}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
         <link href="{!! asset('public/admincss/font-awesome.min.css')!!}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{!! asset('public/admincss/AdminLTE.css')!!}" rel="stylesheet" type="text/css" />
       <link rel="shortcut icon" href="{!! asset('siteimages/site/logo.png') !!}">
    </head>
    <body class="bg-black"   style="background-image: url({!! asset('siteimages/site/login_logo.png')!!});
    background-position: center;
    background-size: 100%;
    height: 100vh;
    overflow: hidden;">

        <div class="form-box" id="login-box">

            <div class="header">

                @if(Session::has('message')) 
                        <div class=" alert alert-danger" style="font-size: 20px;"> 
                        <span class="glyphicon glyphicon-remove ">
                        </span><em> {!! session('message') !!}</em>
                        </div>
                @else
                {{'Enter Your Registered Email'}}
                    @endif 
                

            </div>
            <form action="{{ url('admin/sendpassword') }}" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="body bg-gray">
                    <div class="form-group">
                      <input type="text" name="email" class="form-control" autocomplete="off" placeholder="Email ID"/>
                    </div>
                 
                </div>
                <div class="footer">  
                    
                    <input type="hidden" name="login" value="login">
                    <button type="submit" class="btn bg-olive btn-block">Send me</button>                     
                    <!--<p><a href="{{ url('admin/forgotpass') }}">I forgot my password</a></p>
                    -->
                     
                    
                     </div>
                
            </form>

          
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
       <script src="public/adminjs/bootstrap.min.js" type="text/javascript"></script>          

    </body>
</html>