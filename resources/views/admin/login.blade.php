<!DOCTYPE html>
<html class="bg-black">
   <head>
        <meta charset="UTF-8">
        <title>Zig-Zag | Login</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{!! asset('public/admincss/bootstrap.min.css')!!}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{!! asset('public/admincss/font-awesome.min.css')!!}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{!! asset('public/admincss/AdminLTE.css')!!}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{!! asset('siteimages/site/logo.png') !!}">
        <script>
           
        </script>
        
       
    </head>
    <body class="bg-black"   style="background-image: url({!! asset('siteimages/site/login_logo.png')!!});
    background-position: center;
    background-size: 100%;
    height: 100vh;
    overflow: hidden;">
<!--<h2>Coming Soon...</h2>-->
<!--<img src="{{url('public/assets/logos.png')}}"></img>-->
        <div class="form-box" id="login-box" style="display:block;">
 @if ($errors->count() > 0)
             <div class="alert alert-danger">
               <ul>
                 @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                 @endforeach
               </ul>
             </div>
           @endif
              @if(Session::has('error_message'))         
            <div class="alert alert-danger">
              {!! session('error_message') !!}
            </div>
             @endif 
              @if(Session::has('msg'))        
            <div class="alert alert-success">
              {!! session('msg') !!}
            </div>
             @endif 
            
            
            
            <div class="header">
                {{'Provide Email Id'}}
             </div>
            <form action="{{ url('admin/login') }}" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="body bg-gray">
                    <div class="form-group">
                      <input type="text" name="email" class="form-control" autocomplete="off" placeholder="Email ID"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password"/>
                    </div>          
                    <!--<div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>-->
                </div>
                <div class="footer">  
                	<p style="float:right;"><a href="{{ url('signup-as-provider')}}">Signup as provider</a></p>
					<input type="hidden" name="login" value="login">
                    <button type="submit" class="btn bg-olive btn-block">Log In</button>                     
                    <p><a href="{{ url('admin/forgotpass')}}">I forgot my password</a></p>
                     </div>
				
            </form>

        </div>


        <!-- jQuery 2.0.2 -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="public/adminjs/bootstrap.min.js" type="text/javascript"></script>     
        <script>
		$(".alert-danger,.alert-success, .alert-info").fadeTo(2000, 600).slideUp(600, function(){
			$(".alert-danger,.alert-success").slideUp(600);
		});
		</script>

    </body>
</html>