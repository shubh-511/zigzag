@extends('layouts.m_layout')
@section('title','Zig-Zag')
@show
@section('content')
    
    @if(!empty($page))
        @if($page->id=='1' || $page->slug=='terms-and-services')
         
        <?php //print_r($page);  ?>
     
        <section class="bg-white wide-tb-10" id="intro" style="padding: 8px;">
            <div class="container">
              

                    <div class="row d-flex align-items-center">
                        
                        <div class="col-lg-6 col-sm-12 text-md-right order-lg-1 banner-img" style="text-align: justify;color: grey;
    font-family: "Open Sans", Arial, sans-serif;
    font-size: 14px;">
                            @if(!empty($page->short_des_image))
                            <img src="{{ asset($page->short_des_image)}}" alt="">
                            @endif
                            
                        </div>
                        <div class="col-lg-6 col-sm-12" style="text-align: justify;color: grey;
    font-family: "Open Sans", Arial, sans-serif;
    font-size: 14px;">
                            
                            {!! $page->short_description!!}
                            
                            {!! $page->long_description!!}
                                
                           
                        </div>
                        
                    </div>
                
            </div>
        </section>
        <!-- Welcome To Cargo End --> 
        @elseif($page->id=='2' || $page->slug=='privacy-policy')
        
        <section class="bg-white wide-tb-10" id="intro" style="padding: 8px;">
            <div class="container" style="
    padding: 25px;
    text-align: justify;
">
              

                    <div class="row d-flex align-items-center">
                        
                        <div class="col-lg-6 col-sm-12 text-md-right order-lg-1 banner-img" style="text-align: justify;color: grey;
    font-family: "Open Sans", Arial, sans-serif;
    font-size: 14px;">
                            @if(!empty($page->short_des_image))
                            <img src="{{ asset($page->short_des_image)}}" alt="">
                            @endif
                            
                        </div>
                        <div class="col-lg-6 col-sm-12" style="text-align: justify;color: grey;
    font-family: "Open Sans", Arial, sans-serif;
    font-size: 14px;">>
                            
                            {!! $page->short_description!!}
                            
                            {!! $page->long_description!!}
                                
                           
                        </div>
                        
                    </div>
                
            </div>
        </section>
        
        @elseif($page->id=='7' || $page->slug=='how-it-works')
        <!-- video-popup Decription Start -->
        <section class="bg-white wide-tb-10" id="works">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-12 col-md-6 text-md-right banner-img animated order-md-1" data-animation="fadeInRight" data-animation-delay="100">
                        <div class="bg-fixed pos-rel video-popup" style="margin: 0 !important">
                          <div class="zindex-fixed pos-rel">
                            <a href="#" class="play-video"><i class="icofont-play icofont-4x"></i></a>
                          </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-12 col-md-6 animated" data-animation="fadeInLeft" data-animation-delay="100">
                        {!! $page->short_description!!}
                        
                        <div class="theme-collapse">
                            {!! $page->long_description!!}
                       
                      </div>
                    </div>                    
                </div>
            </div>
        </section>
        <!-- Video Decription End -->
        @elseif($page->id==20 || $page->slug=='faqs')
        
        <!-- FAQ's -->
        <section class="bg-light-white wide-tb-30 faqs">
            <div class="container">
                <div class="row">
                    <!-- Heading Main -->
                    <!--<div class="col-sm-12">-->
                    <!--  <div class="heading-main">-->
                    <!--    <span>Frequently Asked</span>-->
                    <!--    Questions-->
                    <!--    <div class="star-bg"><span class="bg-light-gray"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>            -->
                    <!--  </div>-->
                    <!--</div>-->
                    <!-- Heading Main -->
                @if(!empty($faqs))  
                    @if(count($faqs)>0)
                      @foreach($faqs as $faq)
                      <!-- Questions -->
                    <div class="col-sm-12 col-md-6" data-wow-delay="0s">
                        <h4 class="h4-md mb-3 txt-black">{!! $faq->question!!}</h4>
                        <p>{!! $faq->answer!!}</p>
                    </div>
                    <!-- Questions -->
                      @endforeach
                    @endif
                @endif
                
                    

                    <!-- Questions -->
                    <!--<div class="col-sm-12 col-md-6" data-wow-delay="0.2s">-->
                    <!--    <h4 class="h4-md mb-3 txt-black">Aliquam dapibus pretium ornare?</h4>-->
                    <!--    <p>Feugiat eros ligula massa lipsum primis in orci luctus et ultrices posuere cubilia curae congue lorem. ante ipsum primis in faucibus bibendum sit amet in odio</p>-->
                    <!--</div>-->
                    <!-- Questions -->

                    <!-- Questions -->
                    <!--<div class="col-sm-12 col-md-6" data-wow-delay="0.4s">-->
                    <!--    <h4 class="h4-md mb-3 txt-black">Placeat axime facere omnis volute?</h4>-->
                    <!--    <p>Etiam sit amet mauris suscipit sit amet in odio. Integer congue leo metus. Vitae arcu mollis blandit ultrice ligula egestas magna suscipit lectus magna suscipit luctus undo blandit vitae purus laoreet</p>-->
                    <!--</div>-->
                    <!-- Questions -->

                    <!-- Questions -->
                    <!--<div class="col-sm-12 col-md-6" data-wow-delay="0.6s">-->
                    <!--    <h4 class="h4-md mb-3 txt-black">Dapibus lobortis pretium ornare?</h4>-->
                    <!--    <p>Feugiat eros ligula massa lipsum primis in orci luctus et ultrices posuere cubilia curae congue lorem. ante ipsum primis in faucibus bibendum sit amet in odio</p>-->
                    <!--</div>-->
                    <!-- Questions -->

                    <!-- Questions -->
                    <!--<div class="col-sm-12 col-md-6" data-wow-delay="0.8s">-->
                    <!--    <h4 class="h4-md mb-3 txt-black">An interdum lobortis pretium ornare?</h4>-->
                    <!--    <p>Etiam sit amet mauris suscipit sit amet in odio. Integer congue leo metus. Vitae arcu mollis blandit ultrice ligula egestas magna suscipit lectus magna suscipit luctus undo blandit vitae purus laoreet</p>-->
                    <!--</div>-->
                    <!-- Questions -->

                    <!-- Questions -->
                    <!--<div class="col-sm-12 col-md-6" data-wow-delay="0.9s">-->
                    <!--    <h4 class="h4-md mb-3 txt-black">Interdum lobortis pretium ornare?</h4>-->
                    <!--    <p>Feugiat eros ligula massa lipsum primis in orci luctus et ultrices posuere cubilia curae congue lorem. ante ipsum primis in faucibus bibendum sit amet in odio</p>-->
                    <!--</div>-->
                    <!-- Questions -->
                </div>
            </div>
        </section>
        <!-- FAQ's -->
        @elseif($page->id==21 || $page->slug=='help')
        <!-- Help -->
        <section class="bg-light-white wide-tb-30 faqs">
            <div class="container">
                <div class="row">
                    <!-- Heading Main -->
                    <!--<div class="col-sm-12">-->
                    <!--  <div class="heading-main">-->
                    <!--    <span>How Can I Help You</span>-->
                    <!--    Help-->
                    <!--    <div class="star-bg"><span class="bg-light-gray"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>            -->
                    <!--  </div>-->
                    <!--</div>-->
                    <!-- Heading Main -->
               
                    

                    <!-- Questions -->
                    <div class="col-sm-12 col-md-12" data-wow-delay="0.2s">
                        <h4 class="h4-md mb-3 txt-black">{!!$page->short_description!!}</h4>
                        {!! $page->long_description !!}
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- Help -->
        @elseif($page->id==22 || $page->slug=='privacy-policy')
        <!-- Privacy Policy -->
        <section class="bg-light-white wide-tb-30 faqs">
            <div class="container">
                <div class="row">
                    <!-- Heading Main -->
                    <!--<div class="col-sm-12">-->
                    <!--  <div class="heading-main">-->
                    <!--    <span>Privacy Policy For X4US</span>-->
                    <!--    Privacy Notice-->
                    <!--    <div class="star-bg"><span class="bg-light-gray"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>            -->
                    <!--  </div>-->
                    <!--</div>-->
                    <!-- Heading Main -->
               
                    

                    <!-- Questions -->
                    <div class="col-sm-12 col-md-12" data-wow-delay="0.2s">
                        <!--<h4 class="h4-md mb-3 txt-black">{!!$page->short_description!!}</h4>-->
                        {!! $page->short_description !!} 
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- Privacy Policy -->
        @endif    
    @endif
@stop

@push('footer-js')
<input type="hidden" name="base" value="{{env('APP_URL')}}" id="base">

    <!-- Main JavaScript -->
    <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/fontawesome-all.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.appear.js')}}"></script>
    <script src="{{ asset('assets/js/jarallax.js')}}"></script>
    <script src="{{ asset('assets/js/plugins.js')}}"></script>
    <script src="{{ asset('assets/js/site-custom.js')}}"></script>
@endpush


