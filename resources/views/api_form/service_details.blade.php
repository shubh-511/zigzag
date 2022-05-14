 
    <head>
       <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <link rel="stylesheet" href="{!! asset('assets/css/master.css') !!}">
	<link rel="stylesheet" href="{!! asset('assets/css/responsive.css') !!}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    </head>
   
        <section class="white-bg">
  <div class="container">
    <div class="row">
      @if(!empty($service_details))  
      <div class="col-md-8">
        <div class="post mb-20">
          <div class="post-info">
            <h1><a href="blog-grid.html">
              {{ $service_details->name}}</a></h1>
              <h6 class="purple-color">Service</h6>

            </div>
            <div class="post-img"> <img class="img-responsive" src="{{ asset($service_details->image)}}" alt=""/> </div>
            <p>&nbsp;</p>
            {!! $service_details->description!!}

          </div>
        </div>
        @else
            {{$error}}
        
        @endif
    </div>
  </div>
 </section>
    
