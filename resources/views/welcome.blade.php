@extends('layouts.app')
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
            <div class="head-bottom-meta d-flex justify-content-between align-items-end col-lg-12">
                <div class="col-lg-6"></div>
                <div class="col-lg-6 flex-row d-flex meta-right no-padding justify-content-end">
                    <div class="user-meta">
                        <h4 class="text-white">Abdulrahman Faid</h4>
                        <p>10/2018</p>
                    </div>
                    <img class="img-fluid user-img" src="{{asset('design')}}/img/owner.jpg" width="40" height="40">
                </div>
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
        <a href="{{route('threads.index')}}?filter=popular" style="margin: auth" class="primary-btn load-more pbtn-2 text-uppercase mx-auto mt-60">Load More </a>

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


@endsection