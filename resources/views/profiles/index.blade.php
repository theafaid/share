@extends('layouts.app')
@section('title')
    Edit My Profile | Share
@endsection

@section('content')
    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
        <div class="container">
            <div class="row justify-content-between align-items-center d-flex">
                <div class="col-lg-8 top-left">
                    <h1 class="text-white mb-20">Edit My Profile</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End top-section Area -->

    <div class="post-wrapper pt-100">
        <!-- Start post Area -->
        <section class="post-area">
            <div class="container">
                <div class="row justify-content-center d-flex">
                    <div class="col-lg-8">
                        @if(session()->has('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                        @if(count($errors))
                            @include("layouts.partials.__errors")
                        @endif

                        <div class="post-lists">

                            <form action="{{route('myprofile')}}" method="POST">
                                @csrf
                                {{method_field('PATCH')}}
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" type="text" name="username" value="{{auth()->user()->username}}">
                                </div>

                                <div class="form-group">
                                    <label>Password <small>(If you don't want to update your password just leave it.)</small></label>
                                    <input class="form-control" type="password" name="password">
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-info" type="submit" value="Update My Profile">
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4 sidebar-area">
                        <div class="single_widget search_widget">
                            <div id="imaginary_container">
                                <h2>Your Profile Pic</h2><hr>
                                <user-avatar-form :data="{{json_encode(auth()->user()->avatarPath)}}"></user-avatar-form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End post Area -->
    </div>

@endsection