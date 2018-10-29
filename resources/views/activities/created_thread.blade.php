@component('components.activity')
    @slot('title')
        {{$user->username}} has created new thread
        <a href="{{route('threads.show', $activity->subject->slug)}}">{{$activity->subject->title}}</a>
        <span class="btn btn-info float-right">{{$date}}</span>
    @endslot

    @slot('body')
        {!! str_limit($activity->subject->body, 300) !!}
    @endslot
@endcomponent