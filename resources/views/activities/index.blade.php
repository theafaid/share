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
                    <h1 class="text-white mb-20">{{$title}} ( {{count($userActivities)}} )</h1>
                </div>

                <a href="{{route('profile', $user->username)}}" class="btn btn-info">Show {{$user->username}} Threads</a>
            </div>
        </div>
    </section>
    <!-- End top-section Area -->


    <!-- Start post Area -->
    <div class="post-wrapper pt-100">
        <!-- Start post Area -->
        <section class="post-area">
            <div class="container">
                @forelse($userActivities as $date => $activities)
                    @foreach($activities as $activity)
                        @if(view()->exists("activities.{$activity->type}"))
                            @include("activities.{$activity->type}")
                        @endif
                    @endforeach
                @empty
                    <div class="alert alert-danger">We Found [0] Activities in {{$title}}</div>
                @endforelse
            </div>
        </section>
        <!-- End post Area -->
    </div>
    <!-- End post Area -->
    <br>
@endsection