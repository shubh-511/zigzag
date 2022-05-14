<!DOCTYPE html>
<html lang="en">
@include('homeinclude.sp_business_head') 
<body>
	<!--=== Loader Start ======-->
<!--	<div id="loader-overlay">
		<div class="loader">
			<div class="loader-inner"></div>
		</div>
	</div>
-->
	<!--=== Loader End ======-->
	<!--=== Wrapper Start ===-->
	<div class="wrapper"> 
		@include('homeinclude.header')

		@yield('content')
		@include('homeinclude.sp_business_footer')
		@yield('extra_js')
	</body>



	</html>