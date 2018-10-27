@extends('layouts.app')
@section('title')
    {{$title}}
@endsection

@section('content')
    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
        <div class="container">
            <div class="row justify-content-between align-items-center d-flex">
                <div class="col-lg-8 top-left">
                    <h1 class="text-white mb-20">{{$title}}</h1>
                    <pre>
                        <span>Member Since {{$profileUser->created_at->diffForHumans()}}</span>
                    </pre>

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
                    <div class="col-lg-12">
                        <div class="post-lists">
                            @forelse($threads as $thread)
                                <div class="single-list flex-row d-flex">
                                    <div class="thumb">
                                        <div class="date">
                                            <span>{{$thread->created_at}}</span>
                                        </div>
                                        <img src="{{$thread->image()}}" width="197" height="183" alt="{{$thread->title}}">
                                    </div>
                                    <div class="detail">
                                        <a href="{{route('threads.show', $thread->slug)}}"><h4 class="pb-20">{{$thread->title}}</h4></a>
                                        <p>
                                            {{str_limit($thread->body, 200)}}
                                        </p>
                                        <p class="footer pt-20" style="display:inline">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            {{$thread->likes_count}} {{str_plural("Like", $thread->likes_count)}}
                                            <i class="ml-20 fa fa-comment-o" aria-hidden="true"></i>
                                            {{$thread->comments_count}} {{str_plural('Comment', $thread->comments_count)}}

                                            <p class="footer pt-20 float-right">
                                                Channel:
                                                <a href="{{route("channels.show", $thread->channel->slug)}}">{{$thread->channel->name}}</a>
                                            </p>
                                        </p>


                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-danger">0 Threads Founded In [ {{$title}} ]</div>
                            @endforelse
                        </div>

                        <div class="from-group">
                            {{$threads->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End post Area -->
    </div>
    <!-- End post Area -->
    <br>
@endsection