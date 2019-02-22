<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Meta Description -->
    <meta name="description" content="Share is a simple knowledge sharing through information, skills, or expertise.">
    <!-- Meta CSRF_TOKENS -->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="icon" href="{{asset('design')}}/img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="Abdulrahman Faid">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="share,knowledge,learn,education,threads,channels,subscribe,experince">
    <!-- Site Title -->
    <title>@yield('title', 'Welcome To Share')</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!--
    CSS
    ============================================= -->
    <link rel="stylesheet" href="{{asset('design')}}/css/linearicons.css">
    <link rel="stylesheet" href="{{asset('design')}}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('design')}}/css/bootstrap.css">
    <link rel="stylesheet" href="{{asset('design')}}/css/owl.carousel.css">
    <link rel="stylesheet" href="{{asset('design')}}/css/main.css">
    <link rel="stylesheet" href="{{asset('design')}}/css/jquery.atwho.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <style>
        *, body{
            font-family: 'Open Sans', sans-serif;
        }
    </style>

    <script>
        user = {!! json_encode([
			'id' => auth()->user() ? auth()->user()->id : null
			]) !!}

    </script>

    @stack('head')
</head>
<body>
<!-- Start Header Area -->
<header class="default-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{url('')}}">
                <img width="125" height="30"  src="{{asset('design')}}/img/logo.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav">

                    @auth
                        <li class="dropdown">
                            <notification></notification>
                        </li>
                    @endauth

                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Channels
                        </a>
                        <div class="dropdown-menu">
                            @foreach($channels as $channel)
                                <a class="dropdown-item" href="{{route('channels.show', $channel->slug)}}">{{$channel->name}}</a>
                            @endforeach
                        </div>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Filter Threads By
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('threads.index')}}">Latest</a>
                            <a class="dropdown-item" href="{{route('threads.index')}}?filter=popular">Popular</a>
                            <a class="dropdown-item" href="{{route('threads.index')}}?filter=unanswered">Unanswered</a>
                        </div>
                    </li>




                    <!-- Dropdown -->
                    @auth
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                {{auth()->user()->username}}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('profile', auth()->user()->username)}}">My Profile</a>
                                <a class="dropdown-item" href="{{route('threads.create')}}">Create New Thread</a>
                                <a class="dropdown-item" href="/threads?by={{auth()->user()->username}}">My Threads</a>
                                <a class="dropdown-item" href="{{route('activities', auth()->user()->username)}}">My Activities</a>
                                <a class="dropdown-item" href="{{route('myprofile')}}">Profile Settings</a>
                                <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                            </div>
                        </li>
                    @else
                        <li><a href="{{route('login')}}">Login</a></li>
                        <li><a href="{{route('register')}}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @auth
        @if(auth()->user() && ! auth()->user()->hasVerifiedEmail())
            <div class="alert alert-danger" style="margin:0">
                Please Verify Your Email Address To Start Create Threads and Edit Your Profile ..
                <a href="/email/resend">Click Here</a>
            </div>
        @endif
    @endauth
</header>
<!-- End Header Area -->


@section('content')
<!-- start banner Area -->
<section class="banner-area relative" id="home" data-parallax="scroll" data-image-src="{{asset('design')}}/img/header-bg.jpg">
    <div class="overlay-bg overlay"></div>
    <div class="container">
        <div class="row fullscreen">
            <div class="banner-content d-flex align-items-center col-lg-12 col-md-12">
                <h1>
                    Share is a simple knowledge sharing through <br> information, skills, or expertise .
                </h1>
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->

<section class="category-area section-gap" id="news">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-70 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Popular Threads</h1>
                </div>
            </div>
        </div>
        <div class="active-cat-carusel text-center">
            @foreach($popularThreads as $thread)
                <div class="item single-cat">
                    <img src="{{$thread->imagePath}}" alt="{{$thread->title}}" width="360" height="220">
                    <p reach($latestThreads as $thread)
                       class="date">{{$thread->created_at}}</p>
                    <h4><a href="{{route("threads.show", $thread->slug)}}">{{$thread->title}}</a></h4>
                </div>
            @endforeach
        </div>
        <a href="{{route('threads.index')}}?filter=popular" style="margin: auth" class="primary-btn load-more pbtn-2 text-uppercase mx-auto mt-60">Load More ..</a>

    </div>

</section>

<section class="category-area section-gap" id="news">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-70 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Latest Threads</h1>
                </div>
            </div>
        </div>
        <div class="active-cat-carusel text-center">
            @foreach($latestThreads as $thread)
                <div class="item single-cat">
                    <img src="{{$thread->imagePath}}" alt="{{$thread->title}}" width="360" height="220">
                    <p reach($latestThreads as $thread)
                       class="date">{{$thread->created_at}}</p>
                    <h4><a href="{{route("threads.show", $thread->slug)}}">{{$thread->title}}</a></h4>
                </div>
            @endforeach
        </div>
        <a href="{{route('threads.index')}}" style="margin: auth" class="primary-btn load-more pbtn-2 text-uppercase mx-auto mt-60">Load More </a>

    </div>

</section>
<!-- start footer Area -->
<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6  col-md-12">
                <div class="single-footer-widget newsletter">
                    <h6>What is share ?</h6>
                    <p>
                        Share is a simple knowledge sharing through
                        information, skills, or expertise .
                        It includes a lot of
                        simple features and also advanced features.
                    <hr>
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> Share | This site is made by <a class="badge badge-primary" href="https://www.abdulrahmanfaid.com">A||F</a> and it just for testing.

                </div>
            </div>
            <div class="col-lg-3  col-md-12">
                <div class="single-footer-widget">
                    <h6>Useful Links</h6>
                    <ul class="footer-nav">
                        <li><a href="#">Latest Threads</a></li>
                        <li><a href="#">Popular Threads</a></li>
                        <li><a href="#">Unanswered Threads</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End footer Area -->
<script src="{{asset('design')}}/js/vendor/jquery-2.2.4.min.js"></script>
<script src="{{asset('design')}}/js/vendor/bootstrap.min.js"></script>
<script src="{{asset('design')}}/js/parallax.min.js"></script>
<script src="{{asset('design')}}/js/owl.carousel.min.js"></script>
<script src="{{asset('design')}}/js/jquery.magnific-popup.min.js"></script>
<script src="{{asset('design')}}/js/jquery.sticky.js"></script>
<script src="{{asset('design')}}/js/main.js"></script>
</body>
</html>