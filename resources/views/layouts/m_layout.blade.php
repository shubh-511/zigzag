<!DOCTYPE html>
<html lang="en">
    <head>
	@include('homeinclude.head')
	
	</head>
<body>
  

 <main role="main" id="body-content">

	@yield('content')
</main>

@stack('extra-js')

   
 
</body>

</html>