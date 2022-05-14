<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HOD | Reset-Password</title>
<style type="text/css">
.header{font-family:Arial;font-size:1.5em;font-weight:bold;color:#121212;}
.txt{font-family:Arial;font-size:0.9em;color:#121212;}
.txt a{font-family:Arial;font-size:0.9em;color:#0000FF;text-decoration:none;}
.txt a:hover{font-family:Arial;font-size:0.9em;color:#0000FF;text-decoration:none;}
.fttxt{font-family:Arial;font-size:0.8em;color:#121212;line-height:18px}
.txt1{font-family:Arial;font-size:0.8em;color:#121212;}
.txt-red{font-family:Arial;font-size:1.2em;color:#ff0000;}
</style>
</head>

<body style="
    width: 358px;
    margin: 0px auto;
    /*background-color: #6a8a76;*/
    background-image: url('{{env('APP_URL').'public/assets/login1.png'}}');
    padding: 61px;
    border-radius: 5px;
    margin-top: 0px;
    background-size: 100%;
">
<div class="pg-bg">
  <div class="login-box" style="padding-top:50px;">
  <!--div class="login-logo">
    <a href="../../index2.html"><img src="http://xtensions4us.com/wp-content/uploads/2018/07/logonew.png" alt="logo" class="img-responsive"></a>
  </div-->
  <!-- /.login-logo -->
  <div class="card">
      <img style="width: 200px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    position: relative;
    bottom: 35px;" src="{{url('public/assets/logo.png')}}"> 
    <p class="login-box-msg" style="
   color: #fff;
    font-weight: 700;
    font-size: 21px;
        text-align: center;
    margin-top: -20px;
">Reset Password</p>
    <div class="card-body login-card-body">
        @if(Session::has('success_message')) 
        <style>
        .form-group{display: none;}
        .btn.btn-gradient.btn-md{display: none;}
        </style>
                        <div class=" alert alert-success" style="font-size: 15px;"> 
                        <span class="glyphicon glyphicon-ok ">
                        </span><em style="
    color: #91e9a4;
    text-align: center;
    display: block;
    font-weight: 700;
    font-size: 21px;
"> {!! session('success_message') !!}</em>
                        </div>
            @elseif(Session::has('error_message'))
                        <div class=" alert alert-danger" style="font-size: 15px;"> 
                        <span class="glyphicon glyphicon-remove ">
                        </span><em style="
   text-align: center;
    display: block;
    color: #8a1e1e;
    font-weight: 700;
    font-size: 21px;
"> {!! session('error_message') !!}</em>
                        </div>
            @else
                
            @endif
      

            <form name="contact-form" id="contact-form" action="{{ url('reset-password',[$email])}}" method="POST">
                <div class="row">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="col-md-12 col-sm-12">
    
                    <div class="form-group" style="
    padding: 23px;
">
                      <label for="name" style="
    right: 9px;
     color: #fff; 
    position: relative;
">New Password </label>
                      <input type="password" style="
    padding: 7px;
" name="password" id="password" class="form-control"  required>
                      <span id='new_message' class="fa"></span>
                    </div>
                    
                    <div class="form-group">
                      <label for="name" style="
    right: 9px;
     color: #fff; 
    position: relative;
">Confirm Password </label>
                      <input type="password" style="
    padding: 7px;
" name="confirm_password" id="confirm_password" class="form-control"  required>
                      <span id='message' class="fa"></span>
                    </div>
                  </div>
                  
                    
                  
                  <div class="col-md-12 col-sm-12">
                    <div class="text-left">
                      <br>
                      <button type="submit" name="submit" class="btn btn-gradient btn-md" style="margin-left: 169px;
    padding: 9px 23px;
    background-color: #4a6531;
    border-radius: 2px;
    border: 1px solid #4a6531;
    color: #e3dede;"><span>Submit</span></button>
                    </div>
                  </div>
                   
                  <input type="hidden" name="email" value="{{$email}}"> 
                   
                  
                </div>
            </form>

       
      <!-- /.social-auth-links -->

     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>

</body>
@yield('extra-css')
<script type="text/javascript">

    $(document).ready(function(){

      $("#password").keydown (function (e) 
      {
           
// alert ($(this).val());
        if(String.fromCharCode(e.which)==' ')
        {
          $('#new_message').html('Spaces are not allowed').css('color', 'red');
        }
        else if($(this).val()==' ')
        {
          $('#new_message').html('');
        }
        });
    /*  $('#password').blur(function(e) {
        if($('#password').val()=='')
        {
          $('#new_message').html('');	
        }

      }); 
      */

      $('#confirm_password, #password').blur( function () {
        if($('#confirm_password').val()!='')
        {
          if ($('#password').val() == $('#confirm_password').val()) {
            $('#message').html('&#xf058;').css('color', 'green');
          } 
          else 
            $('#message').html('Password not matched').css('color', 'red');
        }
        else
        {
          $('#message').html('').css('color', 'green');
        }
      });
    $('#password').blur(function(e) {
         if($('#password').val()=='')
        {
          $('#new_message').html('');	
        }
        if($('#password').val()!='')
        {
          var value = document.getElementById('password').value;	
          if (value.length>=6) 
          {
            $('#new_message').html('&#xf058;');
            $('#new_message').css('color', 'green');
          }
          else if(value.length<8) 
          {
            $('#new_message').html('Password should not less than 6 characters');
            $('#new_message').css('color', 'red');
          }
        }
        else
        {
          $('#new_message').html('');	
        }

      }); 
      
    });
 </script>
</body>
        

@section('extra_js')
</html>

