<div class="card">
    <div class="card-header">
        {{$user->username}} has created new thread
        <a href="{{route('threads.show', $activity->subject->slug)}}">{{$activity->subject->title}}</a>
        <span class="btn btn-info float-right">{{$date}}</span>
    </div>
    <div class="card-body">
        {{str_limit($activity->subject->body, 300)}}
    </div>
</div>
<br>