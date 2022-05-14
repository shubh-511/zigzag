<!DOCTYPE html>
<html lang="en">
	@include('homeinclude.head')

<body>
<h2>Coming Soon...</h2>
<!--=== Loader Start ======-->
<!-- <div id="loader-overlay">
  <div class="loader">
    <div class="loader-inner"></div>
  </div>
</div>-->
 
<!--=== Loader End ======--> 


<!--=== Wrapper Start ===-->
<?php /*?><div class="wrapper"> 
	@include('homeinclude.header')
  
	@yield('content')
    
	@include('homeinclude.footer')
	
</div>
   <!--=== Javascript Plugins ===--> 

<script src="{!! asset('assets/js/jquery.min.js') !!}"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script>
w3.slideshow(".mySlides", 3000);
</script>
<script src="{!! asset('assets/js/smoothscroll.js') !!}"></script> 
<!--<script src="assets/js/plugins.js"></script>--> 
<script src="{!! asset('assets/js/master.js') !!}"></script>  
 <script>
        (function(){
         var timeout = 15000; // in miliseconds (4*1000)
            $('.alert').delay(timeout).fadeOut(1500);
            })();
    </script>
@yield('extra-css')
@yield('extra_js')<?php */?>
</body>

</html>