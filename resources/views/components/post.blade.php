<a href="/post/{{$post->id}}" class="list-group-item list-group-item-action">
    <img class="avatar-tiny" src="{{$post->user->avatar}}" />
    <strong>{{$post->title}}</strong> 
    <span class="text-muted small">
        @if (!isset($hideAuthor))
            por {{$post->user->username}}     
        @endif
        el {{$post->created_at->format('j/n/Y h:m:s')}}
    </span>
</a>