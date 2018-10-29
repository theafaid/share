@if($activity->subject_type == 'App\Thread')
    @component('components.activity')
        @slot('title')
            {{$user->username}} has Like a thread
            <a href="{{route('threads.show', $activity->subject->likable->slug)}}">{{$activity->subject->likable->title}}</a>
            <span class="btn btn-info float-right">{{$date}}</span>
        @endslot

        @slot('body')
            {{str_limit($activity->subject->likable->body, 300)}}
        @endslot
    @endcomponent
@else

    @component('components.activity')
        @slot('title')
            {{$user->username}} has Liked a reply on
            <a href="{{$activity->subject->likable->path()}}">{{$activity->subject->likable->thread->title}}</a>
            <span class="btn btn-info float-right">{{$date}}</span>
        @endslot

        @slot('body')
            {!! str_limit($activity->subject->likable->body, 300) !!}
        @endslot
    @endcomponent

@endif