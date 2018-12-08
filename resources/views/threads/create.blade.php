@extends('layouts.app')
@section('title')
    Add New Thread
@endsection

@section('content')

    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
        <div class="container">
            <div class="row justify-content-between align-items-center d-flex">
                <div class="col-lg-8 top-left">
                    <h1 class="text-white mb-20">Add Your New Thread</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End top-section Area -->


    <div class="post-wrapper pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    @if(count($errors))
                        @include("layouts.partials.__errors")
                    @endif
                    <form action="{{route('threads.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="lead">Thread Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Title" value="{{old('title')}}" required>
                        </div>

                        <div class="form-group">
                            <label class="lead">Select a Channel</label>
                            <select name="channel_id" class="form-control" required>
                                @foreach(\App\Channel::all() as $channel)
                                    <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? "selected" : ''}}>
                                    {{$channel->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="lead">Thread Body</label>
                            <wysiwyg  ></wysiwyg>
                        </div>

                        <div class="form-group">
                            <label class="lead">Upload Thread Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Post Your Thread">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection