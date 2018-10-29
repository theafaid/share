<div class="single-list flex-row d-flex">
    <div class="thumb">
        <div class="date">
            <span>{{$thread->created_at}}</span>
        </div>
        <img src="{{$thread->imagePath}}" width="197" height="183" alt="{{$thread->title}}">
    </div>
    <div class="detail">
        <a href="{{route('threads.show', $thread->slug)}}">
            @if($thread->hasUpdatesFor())
                <h4 style="color:#0080ff" class="pb-20">{{$thread->title}}</h4>
            @else
                <h4 class="pb-20">{{$thread->title}}</h4>
            @endif
        </a>
        <p>
            {{str_limit($thread->body, 200)}}
        </p>
        <p class="footer pt-20" style="display:inline">
            <i class="fa fa-heart-o" aria-hidden="true"></i>
            {{$thread->likes_count}} {{str_plural("Like", $thread->likes_count)}}
            <i class="ml-20 fa fa-comment-o" aria-hidden="true"></i>
        {{$thread->comments_count}} {{str_plural('Comment', $thread->comments_count)}}

        <p class="footer pt-20 float-right">
            Channel:
            <a href="{{route("channels.show", $thread->channel->slug)}}">{{$thread->channel->name}}</a>


            <br>

            By:
            <a href="{{route('profile', $thread->user->username)}}">{{$thread->user->username}}</a>
            <img width="30" height="30" src="{{$thread->user->avatarPath}}" width="197" height="183" alt="{{$thread->user->username}}">

        </p>
        </p>

    </div>
</div>
<hr>