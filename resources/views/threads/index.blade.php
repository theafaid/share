@extends('layouts.app')

@section("title")
    {{$title}}
@endsection

@section('content')
    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
        <div class="container">
            <div class="row justify-content-between align-items-center d-flex">
                <div class="col-lg-8 top-left">
                    <h1 class="text-white mb-20"> {{$title}} </h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End top-section Area -->


    <!-- Start post Area -->
    <div class="post-wrapper pt-100">
        <!-- Start post Area -->
        <section class="post-area">
            <div class="container">
                <div class="row justify-content-center d-flex">
                    <div class="col-lg-8">
                        <div class="post-lists">

                            @forelse($threads as $thread)

                                @include("threads._list")

                            @empty

                                <div class="alert alert-danger">
                                    @if(request('q'))
                                        No Result Founded In for searching {{$title}}
                                    @else
                                        0 Result Founded In [ {{$title}} ]
                                    @endif
                                </div>
                            @endforelse
                        </div>

                        <br>

                        <div class="form-group">
                            {{$threads->links()}}
                        </div>
                        <br>
                    </div>

                    <div class="col-lg-4 sidebar-area">
                        <div class="single_widget search_widget">
                            <div id="imaginary_container">
                                <div class="input-group stylish-input-group">
                                    <form action="search" method="GET" class="form-inline">
                                        <input type="text" name="q" class="form-control"  placeholder="Search" value="{{request('q')}}">
                                        <span class="input-group-addon">
                                            <button type="submit">
                                                <span class="lnr lnr-magnifier"></span>
                                            </button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="single_widget cat_widget">
                            <h4 class="text-uppercase pb-20">Trending Threads</h4>
                            <ul>
                                @forelse($trending as $thread)
                                    <li>
                                        <a href="{{$thread->link}}">{{$thread->title}}</a>
                                    </li>
                                @empty
                                    <div class="alert alert-warning">No Trending Threads</div>
                                @endforelse
                            </ul>
                        </div>

                        <div class="single_widget recent_widget">
                            <h4 class="text-uppercase pb-20">Recent Posts</h4>
                            <div class="active-recent-carusel">
                                @foreach($latestThreads as $latestThread)
                                    <div class="item">
                                        <img src="{{$latestThread->imagePath}}" width="250" height="150" alt="">
                                        <p class="mt-20 title text-uppercase">
                                            <a href="{{route('threads.show', $latestThread->slug)}}">{{str_limit($latestThread->title, 40)}}</a>
                                        </p>
                                        <p>{{$latestThread->created_at}}<span></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End post Area -->
    </div>
    <!-- End post Area -->
@endsection