<x-profile :sharedData="$sharedData" doctitle="Seguidores de {{$sharedData['username']}}">
  @include('profile-followers-only')
</x-profile>