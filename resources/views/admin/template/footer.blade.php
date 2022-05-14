 

 </section>

 </aside>

 </div>

 <!-- jQuery 2.0.2 -->

 @stack('footer_multiple')
        <script src="{{ asset('public/js/jquery.min.js')}}"></script>
       
        

        <!-- jQuery UI 1.10.3 -->

        <script src="{{ asset('public/adminjs/jquery-ui-1.10.3.min.js') }}" type="text/javascript"></script>

        <!-- Bootstrap -->

        <script src="{{ asset('public/adminjs/bootstrap.min.js') }}" type="text/javascript"></script>

        <!-- Morris.js charts -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

        <script src="{{ asset('public/adminjs/plugins/morris/morris.min.js') }}" type="text/javascript"></script>

        <!-- Sparkline -->

   		<script src="{{ asset('public/adminjs/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>

        <!-- jvectormap -->

        <script src="{{ asset('public/adminjs/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('public/adminjs/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>

        <!-- fullCalendar -->

        <script src="{{ asset('public/adminjs/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>

        <!-- jQuery Knob Chart -->

       <!-- <script src="../js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>-->

        <!-- daterangepicker -->

        <script src="{{ asset('public/adminjs/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>

        <!-- Bootstrap WYSIHTML5 -->

        <script src="{{ asset('public/adminjs/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>

        <!-- iCheck -->

       <!-- <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>-->



        <!-- AdminLTE App -->

        <script src="{{ asset('public/adminjs/AdminLTE/app.js') }}" type="text/javascript"></script>

        @stack('footer_scrpt')

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

        <script src="{{ asset('public/adminjs/AdminLTE/dashboard.js') }}" type="text/javascript"></script>
<script>
    function deleteMe(id)
        {     
               
            if(confirm("Are you sure delete record(s)?"))
                {
                        $.ajax({
                            type: 'GET',
                            data: {'id':id},
                            url: 'destroy',
                           
                            success: function(result){
                                alert('Deleted');
                            location.reload();
                            
                            }});
                }
    }       
        

</script>
        
    <script>
        /*(function(){
         var timeout = 4000; // in miliseconds (4*1000)
            $('.alert').delay(timeout).fadeOut(400);
            })();
*/
   
    </script>
    <script>
		$(".alert-danger,.alert-success, .alert-info").fadeTo(2000, 600).slideUp(600, function(){
			$(".alert-danger,.alert-success").slideUp(600);
		});
		</script>

    @yield('extra_js')
  
  <script type="text/javascript">
    $(document).ready(function(){

      $('#state_id').on('change',function(){

        var stateID = $(this).val();
        if(stateID){
          $.ajax({
            type:'GET',
            url:'../../../cityData',
            data:'state_id='+stateID,
            success:function(html){
//alert('hello');
$('#city_id').html(html);

}
}); 
        }else{
          $('#city_id').html('<option value="">Select State first</option>');

        }
      });  
    });
</script>
    </body>

</html>