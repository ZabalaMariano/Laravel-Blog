<div class="list-group">
  @foreach ($followers as $follow)
    <a href="/profile/{{$follow->getUserFollowing->username}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$follow->getUserFollowing->avatar}}" />
        <strong>{{$follow->getUserFollowing->username}}</strong>
    </a>
  @endforeach
</div>