<!DOCTYPE html>
<html lang="en">
@include('homeinclude.head')

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
		@include('homeinclude.business_slider')

		@yield('content')

		@include('homeinclude.footer')
	</div>
	@yield('extra_js')
</body>

</html>