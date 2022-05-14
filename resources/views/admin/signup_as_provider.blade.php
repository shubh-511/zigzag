<!DOCTYPE html>
<html class="bg-black">
   <head>
        <meta charset="UTF-8">
        <title>Zig-Zag | Signup as provider</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{!! asset('public/admincss/bootstrap.min.css')!!}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{!! asset('public/admincss/font-awesome.min.css')!!}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{!! asset('public/admincss/AdminLTE.css')!!}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{!! asset('siteimages/site/logo.png') !!}">
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDJl11mAojAFGlCjDrzrZx1LhXozqtA78Y"></script>
        <style> textarea
        {
            resize: vertical;
        }
        </style>
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

		   @if (session('msg'))
             <div class="alert alert-success">
			  <b>{{ session('msg') }}</b>
           @endif

            <div class="header">			

            @if(Session::has('messageok')) 
                        <div class=" alert alert-success" style="font-size: 15px;"> 
                        <span class="glyphicon glyphicon-ok ">
                        </span><em> {!! session('messageok') !!}</em>
                        </div>
            @elseif(Session::has('message'))
                        <div class=" alert alert-success" style="font-size: 15px;"> 
                        <span class="glyphicon glyphicon-ok ">
                        </span><em> {!! session('message') !!}</em>
                        </div>
                        @elseif(Session::has('err_message'))
                        <div class="alert alert-danger">
               <ul>
                 
                  <li>{!! session('err_message') !!}</li>
                 
               </ul>
             </div>
            @else
                {{'Signup As Provider'}}
            @endif 
			
			</div>
            <form action="{{ url('signupasprovider') }}" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="body bg-gray">
                    <div class="form-group">
                      <input type="text" name="provider_name" class="form-control" autocomplete="off" placeholder="Name"/>
                    </div>
                    <div class="form-group">
                      <input type="text" name="email" class="form-control" autocomplete="off" placeholder="Email ID"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password"/>
                    </div> 
					<div class="form-group">
                      <input type="text" name="mobile_number" class="form-control" autocomplete="off" placeholder="Contact Number"/>
                    </div>
                    <div class="form-group">
                      <textarea id="searchInput" class="form-control" autocomplete="off" placeholder="Your address"></textarea>
                      <div style="display:none;" class="map" id="map" style="width: 100%; height: 300px;"></div>
                    </div>
                    <input type="hidden" name="address" id="location">
                    <input type="hidden" name="lattitude" id="lat">
                    <input type="hidden" name="longitude" id="lng">
                    
                </div>
                <div class="footer">  
                	<p style="float:right;"><a href="{{ url('admin/login')}}">Already have an account?</a></p>
					<input type="hidden" name="login" value="login">
                    <button type="submit" class="btn bg-olive btn-block">Sign up</button> 
                </div>
				
            </form>

        </div>

<script>
/* script */
function initialize() {
   var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: true,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            document.getElementById('location').value = '0';
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
       
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
    
        bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
       
    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function() {
		geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {        
              bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
        }
        });
    });
}
function bindDataToForm(address,lat,lng){
   document.getElementById('location').value = address;
   document.getElementById('lat').value = lat;
   document.getElementById('lng').value = lng;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
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