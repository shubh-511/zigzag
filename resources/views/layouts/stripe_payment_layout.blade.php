 <!doctype html>
 <html>
 @include('homeinclude.stripe_payment_head')

 <body>
 	<div id="loader-overlay">
 		<div class="loader">
 			<div class="loader-inner"></div>
 		</div>
 	</div>	
 	<div class="wrapper">
 		@include('homeinclude.header')
 		@yield('content')

 		@include('homeinclude.stripe_payment_footer') 


 		