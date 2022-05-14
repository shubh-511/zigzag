<!--start header section-->
        <header class="header">
            <!--start navbar-->
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="row">
                        <div class="navbar-header page-scroll">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#myNavbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            @php /* env('APP_URL') */ @endphp
                            <a class="navbar-brand page-scroll" href="{{ '#hero' }}">
                                 
                                <img src="{{ asset(Session::get('front_siteInfo')->header_logo)}}" alt="logo" class="logo1" style="height:45px;">
                            </a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="navbar-collapse collapse" id="myNavbar">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="active"><a class="page-scroll" href="#hero">Home</a></li>
                                <li><a class="page-scroll" href="#features">Features</a></li>
                                <li><a class="page-scroll" href="#faqs">Faq</a></li>
                                <li><a class="page-scroll" href="#contact">Contact</a></li>
                                <li><a class="page-scroll" href="#">Login</a></li>
                                <li><a class="page-scroll" href="#">Register</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!--end navbar-->
        </header>
        <!--end header section-->