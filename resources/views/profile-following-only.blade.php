<div class="list-group">
  @foreach ($following as $follow)
    <a href="/profile/{{$follow->getFollowedUser->username}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$follow->getFollowedUser->avatar}}" />
        <strong>{{$follow->getFollowedUser->username}}</strong>
    </a>
  @endforeach
</div>