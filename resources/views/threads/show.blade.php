@extends('layouts.app')

@section('title')
{{$thread->title}}
@endsection


@section('content')
<thread inline-template :data="{{$thread}}" v-cloak>
    <div>
        <!-- Start top-section Area -->
        <section class="top-section-area section-gap">
            <div class="container">
                <div class="row justify-content-between align-items-center d-flex">
                    <div class="col-lg-8 top-left">
                        <h1 class="text-white mb-20">@{{thread.title}}</h1>
                    </div>
                </div>
                @can('update', $thread)
                    <form method="POST" action="{{route('threads.destroy', $thread->slug)}}">
                        @csrf
                        {{method_field('DELETE')}}
                        <button type="submit" class="btn btn-danger float-right"><i class="fa fa-trash"></i></button>
                    </form>
                @endcan
            </div>
        </section>
        <!-- End top-section Area -->


        <!-- Start post Area -->
        <div class="post-wrapper pt-100">
            <!-- Start post Area -->
            <section class="post-area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="single-page-post">

                                <div v-if="editing && authorize('updateThread', thread)">
                                    @include('threads.edit')
                                </div>

                                <div v-else>
                                    @include('threads._post')
                                </div>

                                <div class="bottom-wrapper">
                                    <div class="row">
                                        <div class="col-lg-4 single-b-wrap col-md-12">
                                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                            @{{ thread.likes_count }} Likes
                                        </div>
                                        <div class="col-lg-4 single-b-wrap col-md-12">
                                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                                            @{{thread.comments_count}} Comments
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 single-b-wrap col-md-12">
                                    <div class="addthis_inline_share_toolbox float-right"></div>
                                </div>

                                <!-- Start comment-sec Area -->
                                <section class="comment-sec-area pt-80 pb-80">
                                    <div class="container">
                                        <div class="row flex-column">
                                            <h5 class="text-uppercase pb-80" v-text="thread.comments_count + ' Comments'"></h5>
                                            <br>
                                            <comments
                                                    :locked="thread.locked"
                                                    @increase="thread.comments_count++"
                                                    @decrease="thread.comments_count--">
                                            </comments>
                                        </div>
                                    </div>
                                </section>
                                <!-- End comment-sec Area -->
                            </div>
                        </div>
                        <div class="col-lg-4 sidebar-area ">
                            <div class="single_widget search_widget">
                                <div id="imaginary_container">
                                    <div class="input-group stylish-input-group">
                                        <input type="text" class="form-control"  placeholder="Search" >
                                        <span class="input-group-addon">
                                    <button type="submit">
                                        <span class="lnr lnr-magnifier"></span>
                                    </button>
                                </span>
                                    </div>
                                </div>
                            </div>

                            @auth
                            <div class="single_widget cat_widget">
                                <h4 class="text-uppercase pb-20">Great ?</h4>
                                <div>
                                    <subscribe-thread :data="{{$thread}}"></subscribe-thread>
                                </div>
                            </div>

                            <div class="single_widget cat_widget" v-if="authorize('updateThread', thread)">
                                <h4 class="text-uppercase pb-20">Settings</h4>
                                <div>
                                    <lock-thread :data="{{$thread}}"></lock-thread>
                                </div>
                            </div>

                            @endauth

                            <div class="single_widget cat_widget">
                                <h4 class="text-uppercase pb-20">Post Details</h4>
                                <ul>
                                    <li>
                                        <a href="{{route('channels.show', $thread->channel->slug)}}"> Channel <span>{{$thread->channel->name}}</span></a>
                                    </li>

                                    <li>
                                        <a href="{{route('profile', $thread->user->username)}}"> By  <span>{{$thread->user->username}}</span></a>
                                    </li>
                                    <li>
                                        <a>Since <span v-text="thread.created_at"></span></a>
                                    </li>
                                    <li>
                                        <a>Comments <span v-text="thread.comments_count"></span></a>
                                    </li>
                                    <li>
                                        <a>Likes <span v-text="thread.likes_count"></span></a>
                                    </li>
                                    <li>
                                        <a>Views <span v-text="{{$thread->visits()}}"></span></a>
                                    </li>
                                </ul>
                            </div>

                             <div class="single_widget recent_widget">
                                <h4 class="text-uppercase pb-20">Recent Posts</h4>
                                <div class="active-recent-carusel">
                                    <div class="item">
                                        <img src="img/asset/slider.jpg" alt="">
                                        <p class="mt-20 title text-uppercase">Home Audio Recording <br>
                                            For Everyone</p>
                                        <p>02 Hours ago <span> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                06 <i class="fa fa-comment-o" aria-hidden="true"></i>02</span></p>
                                    </div>
                                    <div class="item">
                                        <img src="img/asset/slider.jpg" alt="">
                                        <p class="mt-20 title text-uppercase">Home Audio Recording <br>
                                            For Everyone</p>
                                        <p>02 Hours ago <span> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                06 <i class="fa fa-comment-o" aria-hidden="true"></i>02</span></p>
                                    </div>
                                    <div class="item">
                                        <img src="img/asset/slider.jpg" alt="">
                                        <p class="mt-20 title text-uppercase">Home Audio Recording <br>
                                            For Everyone</p>
                                        <p>02 Hours ago <span> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                06 <i class="fa fa-comment-o" aria-hidden="true"></i>02</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="single_widget tag_widget">
                                <h4 class="text-uppercase pb-20">Tag Clouds</h4>
                                <ul>
                                    <li><a href="#">Lifestyle</a></li>
                                    <li><a href="#">Art</a></li>
                                    <li><a href="#">Adventure</a></li>
                                    <li><a href="#">Food</a></li>
                                    <li><a href="#">Technology</a></li>
                                    <li><a href="#">Fashion</a></li>
                                    <li><a href="#">Adventure</a></li>
                                    <li><a href="#">Food</a></li>
                                    <li><a href="#">Technology</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End post Area -->
        </div>
        <!-- End post Area -->
    </div>
</thread>
@endsection

@push('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b1e90b0b8b646b3"></script>
@endpush