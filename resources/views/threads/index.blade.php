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
                    <h1 class="text-white mb-20">[ {{$title}} ]</h1>
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

                                <div class="alert alert-danger">0 Result Founded In [ {{$title}} ]</div>
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
                                    <input type="text" class="form-control"  placeholder="Search" >
                                    <span class="input-group-addon">
                                        <button type="submit">
                                            <span class="lnr lnr-magnifier"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="single_widget cat_widget">
                            <h4 class="text-uppercase pb-20">post categories</h4>
                            <ul>
                                <li>
                                    <a href="#">Technology <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Lifestyle <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Fashion <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Art <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Food <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Architecture <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Adventure <span>37</span></a>
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


                        <div class="single_widget cat_widget">
                            <h4 class="text-uppercase pb-20">post archive</h4>
                            <ul>
                                <li>
                                    <a href="#">Dec'17 <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Nov'17 <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Oct'17 <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Sept'17 <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Aug'17 <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Jul'17 <span>37</span></a>
                                </li>
                                <li>
                                    <a href="#">Jun'17 <span>37</span></a>
                                </li>
                            </ul>
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
@endsection