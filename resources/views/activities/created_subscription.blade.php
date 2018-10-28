@if($activity->subject->subscribed_type == 'App\Thread')
    @component('components.activity')
        @slot('title')
                {{$user->username}} has Subscribed a thread
            <a href="{{route('threads.show', $activity->subject->subscribed->slug)}}">{{$activity->subject->subscribed->title}}</a>
            <span class="btn btn-info float-right">{{$date}}</span>
        @endslot

        @slot('body')
            {{str_limit($activity->subject->subscribed->body, 300)}}
        @endslot
    @endcomponent
@else

    @component('components.activity')
        @slot('title')
            {{$user->username}} has Liked a reply onsss
            <a href="{{$activity->subject->likable->path()}}">{{$activity->subject->likable->thread->title}}</a>
            <span class="btn btn-info float-right">{{$date}}</span>
        @endslot

        @slot('body')
            {{str_limit($activity->subject->likable->body, 300)}}
        @endslot
    @endcomponent

@endif