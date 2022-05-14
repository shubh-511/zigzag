<!--start footer section-->
        <footer class="footer-section bg-secondary ptb-60">
            <div class="footer-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="footer-single-col text-center">
                                <a href="{{ env('APP_URL') }}"><img src="{{ asset(Session::get('front_siteInfo')->footer_logo)}}" alt="footer logo"></a>
                                <div class="footer-social-list">
                                    <ul class="list-inline">
                                       
                                      
                        @if(!empty(Session::get('front_siteInfo')->fb_link))        <li title="Facebook" ><a href="{{ Session::get('front_siteInfo')->fb_link }} "> <i class="fa fa-facebook"></i></a></li> @endif
                        @if(!empty(Session::get('front_siteInfo')->twitter_link))   <li title="Twitter"><a href="{{Session::get('front_siteInfo')->twitter_link}}"> <i class="fa fa-twitter"></i></a></li> @endif
                        @if(!empty(Session::get('front_siteInfo')->linkedin_link))  <li title="Linked In"><a href="{{ Session::get('front_siteInfo')->linkedin_link }}"> <i class="fa fa-linkedin"></i></a></li> @endif
                        @if(!empty(Session::get('front_siteInfo')->google_link))    <li title="Google Plus"><a href="{{ Session::get('front_siteInfo')->google_link }}"> <i class="fa fa-google-plus"></i></a></li> @endif
                        @if(!empty(Session::get('front_siteInfo')->youtube_link))   <li title="Youtube"><a href="{{Session::get('front_siteInfo')->youtube_link}}"> <i class="fa fa-youtube"></i></a></li> @endif
                        
                        @if(!empty(Session::get('front_siteInfo')->instagram_link))  <li title="Instagram"><a href="{{Session::get('front_siteInfo')->instagram_link}}"> <i class="fa fa-instagram"></i></a></li> @endif
                        @if(!empty(Session::get('front_siteInfo')->pin_link))       <li title="Pinterest"><a href="{{Session::get('front_siteInfo')->pin_link}}"> <i class="fa fa-pinterest"></i></a></li> @endif
                        @if(!empty(Session::get('front_siteInfo')->dribbble_link))  <li title="Dribbble"><a href="{{Session::get('front_siteInfo')->dribbble_link}}"> <i class="fa fa-dribbble"></i></a></li> @endif
                                         
                                    </ul>
                                </div>
                                <div class="copyright-text">
                                    <p>{{ Session::get('front_siteInfo')->copy_right }} <a href="{{ env('APP_URL') }}">{{ Session::get('front_siteInfo')->site_name }}</a> | Designed & Developed by <a
                                            href="https://www.webmobril.com/" target="_blank">Webmobril</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--end footer section-->
    