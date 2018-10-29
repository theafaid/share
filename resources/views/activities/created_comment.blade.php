@component('components.activity')
    @slot('title')
        {{$user->username}} has created new comment on
        <a href="{{$activity->subject->path()}}">{{$activity->subject->thread->title}}</a>
        <span class="btn btn-info float-right">{{$date}}</span>
    @endslot

    @slot('body')
        {!! str_limit($activity->subject->body, 300) !!}
    @endslot
@endcomponent