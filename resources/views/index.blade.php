<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Royal City</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="favicon.ico">

    <!--Google Font link-->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">


    <link rel="stylesheet" href="{!! asset('landing/assets/css/slick/slick.css') !!}">
    <link rel="stylesheet" href="{!! asset('landing/assets/css/slick/slick-theme.css') !!}">
    <link rel="stylesheet" href="{!! asset('landing/assets/css/animate.css') !!}">
    <link rel="stylesheet" href="{!! asset('landing/assets/css/iconfont.css') !!}">
    <link rel="stylesheet" href="{!! asset('landing/assets/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('landing/assets/css/bootstrap.css') !!}">
    <link rel="stylesheet" href="{!! asset('landing/assets/css/magnific-popup.css') !!}">
    <link rel="stylesheet" href="{!! asset('landing/assets/css/bootsnav.css') !!}">

    <!-- xsslider slider css -->


    <!--<link rel="stylesheet" href="landing/assets/css/xsslider.css">-->


    <!--For Plugins external css-->
    <!--<link rel="stylesheet" href="landing/assets/css/plugins.css" />-->

    <!--Theme custom css -->
    <link rel="stylesheet" href="landing/assets/css/style.css">
    <!--<link rel="stylesheet" href="landing/assets/css/colors/maron.css">-->

    <!--Theme Responsive css-->
    <link rel="stylesheet" href="landing/assets/css/responsive.css"/>

    <script src="landing/assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body data-spy="scroll" data-target=".navbar-collapse">


<!-- Preloader -->
<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="object" id="object_one"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_four"></div>
        </div>
    </div>
</div><!--End off Preloader -->


<div class="culmn">
    <!--Home page style-->


    <nav class="navbar navbar-default bootsnav navbar-fixed">
        <div class="navbar-top bg-grey fix">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="navbar-callus text-left sm-text-center">
                            <ul class="list-inline">
                                <li><a href="tel:+254728585700"><i class="fa fa-phone"></i> Call us: 0728585700</a> <a
                                            href="tel:+254738539653"> 0738539653</a> </li>
                                <li><a href="mailto:cloudwifikach@gmail.com"><i class="fa fa-envelope-o"></i> Contact
                                        us: cloudwifikach@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Top Search -->
        <div class="top-search">
            <div class="container">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search">
                    <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                </div>
            </div>
        </div>
        <!-- End Top Search -->


        <div class="container">
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                </ul>
            </div>

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{!! url('/') !!}">
                    ROYAL CITY
                </a>

            </div>
            <!-- End Header Navigation -->

            <!-- navbar menu -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{!! url('/') !!}">Home</a></li>
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> DashBoard</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endguest
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>

    </nav>

    <!--Home Sections-->

    <section id="home" class="home bg-black fix">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="main_home text-center">
                    <div class="col-md-12">
                        <div class="hello_slid">
                            <div class="slid_item">
                                <div class="home_text ">
                                    <h1 class="text-white">Welcome to <strong>Royal City</strong></h1>
                                    {{--<h3 class="text-white">- We Create a <strong>Concept</strong> into The Market -</h3>--}}
                                </div>

                                {{--<div class="home_btns m-top-40">--}}
                                    {{--<a href="" class="btn btn-primary m-top-20">Buy Now</a>--}}
                                    {{--<a href="" class="btn btn-default m-top-20">Take a Tour</a>--}}
                                {{--</div>--}}
                            </div><!-- End off slid item -->
                            <div class="slid_item">
                                <div class="home_text ">
                                    <h1 class="text-white">We Do Business All Of Time</h1>
                                </div>

                                {{--<div class="home_btns m-top-40">--}}
                                    {{--<a href="" class="btn btn-primary m-top-20">Buy Now</a>--}}
                                    {{--<a href="" class="btn btn-default m-top-20">Take a Tour</a>--}}
                                {{--</div>--}}
                            </div><!-- End off slid item -->
                            <div class="slid_item">
                                <div class="home_text ">
                                    {{--<h2 class="text-white">Welcome to <strong>Royal City</strong></h2>--}}
                                    <h1 class="text-white">Enjoy our services.</h1>
                                    {{--<h3 class="text-white">- We Create a <strong>Concept</strong> into The Market -</h3>--}}
                                </div>

                                {{--<div class="home_btns m-top-40">--}}
                                    {{--<a href="" class="btn btn-primary m-top-20">Buy Now</a>--}}
                                    {{--<a href="" class="btn btn-default m-top-20">Take a Tour</a>--}}
                                {{--</div>--}}
                            </div><!-- End off slid item -->
                        </div>
                    </div>

                </div>


            </div><!--End off row-->
        </div><!--End off container -->
    </section> <!--End off Home Sections-->

    <!--product section-->
    <section id="product" class="product">
        <div class="container">
            <div class="main_product roomy-80">
                <div class="head_title text-center fix">
                    <h2 class="text-uppercase">Our Shops</h2>
                    <p class="text-center">
                        Hello Guys <br>
                        Welcome to our new website. We have prepared a lot of good stuff for you. We aim at providing the best
                        of your online experience where you can have a chance to both buy and sell your goods or services. We
                        hope you enjoy what we have prepared for you. Log in to continue.
                    </p>
                    <br>
                    <br>
                    <br>
                </div>
                @if(isset($shops))
                    @foreach($shops as $shop)
                        <a href="{!! url('shop/'.$shop->byUser) !!}" class="col-sm-3">
                            <div class="port_item xs-m-top-30" style="background-color: #e7e7e7;">
                                <div class="port_img">
                                    <img src="{!! asset('shops/'.$shop->byUser.'.jpeg') !!}" alt="" style="height:200px; width:100%"/>
                                    <div class="port_overlay text-center">
                                    </div>
                                </div>
                                <div class="port_caption m-top-20 text-center">
                                    <h5 class="m-bottom-10">{!! App\User::find($shop->byUser)->name !!}</h5>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div><!-- End off row -->
        </div><!-- End off container -->
    </section><!-- End off Product section -->

    <br>
    <br>
    <br>
    <br>

    <!--Call to  action section-->
    <section id="action" class="action bg-primary roomy-40">
        <div class="container">
            <div class="row">
                <div class="maine_action">
                    <div class="col-md-8">
                        <div class="action_item text-center">
                            <h2 class="text-white text-uppercase"></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="action_btn text-left sm-text-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer id="contact" class="footer action-lage bg-black p-top-80">
        <!--<div class="action-lage"></div>-->
        <div class="container">
            <div class="row">
                <div class="widget_area">
                    <div class="col-md-3">
                        <div class="widget_item widget_about">
                            <h5 class="text-white">About Us</h5>
                            <p class="m-top-20">

                            </p>
                            <div class="widget_ab_item m-top-30">
                                <div class="item_icon"><i class="fa fa-location-arrow"></i></div>
                                <div class="widget_ab_item_text">
                                    <h6 class="text-white">Location</h6>
                                    <p>
                                        In conjunction with Cloud WiFi, we have set up access points in the following locations:
                                        <br>
                                        <ul>
                                            <li>Mbuyu's photocopy shop</li>
                                            <li>Eva's hostels</li>
                                            <li>Seb hostels</li>
                                            <li>Berlin hostels</li>
                                        </ul>
                                    We will soon be adding more access points to have a wider area coverage for your convenience.
                                    </p>
                                </div>
                            </div>
                            <div class="widget_ab_item m-top-30">
                                <div class="item_icon"><i class="fa fa-phone"></i></div>
                                <div class="widget_ab_item_text">
                                    <h6 class="text-white">Phone :</h6>
                                    <p>0728585700</p>
                                    <p>0738539653</p>
                                </div>
                            </div>
                            <div class="widget_ab_item m-top-30">
                                <div class="item_icon"><i class="fa fa-envelope-o"></i></div>
                                <div class="widget_ab_item_text">
                                    <h6 class="text-white">Email Address :</h6>
                                    <p>youremail@mail.com</p>
                                </div>
                            </div>
                        </div><!-- End off widget item -->
                    </div><!-- End off col-md-3 -->
                </div>
            </div>
        </div>
        <div class="main_footer fix bg-mega text-center p-top-40 p-bottom-30 m-top-80">
            <div class="col-md-12">
                <p class="wow fadeInRight" data-wow-duration="1s">
                    Made with
                    <i class="fa fa-heart"></i>
                    by
                    <a target="_blank" href="https://safemoon.com">Safemoon Systems</a>
                    2018. All Rights Reserved
                </p>
            </div>
        </div>
    </footer>


</div>

<!-- JS includes -->

<script src="landing/assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="landing/assets/js/vendor/bootstrap.min.js"></script>

<script src="landing/assets/js/owl.carousel.min.js"></script>
<script src="landing/assets/js/jquery.magnific-popup.js"></script>
<script src="landing/assets/js/jquery.easing.1.3.js"></script>
<script src="landing/assets/css/slick/slick.js"></script>
<script src="landing/assets/css/slick/slick.min.js"></script>
<script src="landing/assets/js/jquery.collapse.js"></script>
<script src="landing/assets/js/bootsnav.js"></script>


<script src="landing/assets/js/plugins.js"></script>
<script src="landing/assets/js/main.js"></script>

</body>
</html>
