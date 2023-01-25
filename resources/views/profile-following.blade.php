<x-profile :sharedData="$sharedData" doctitle="Seguidos por {{$sharedData['username']}}">
  @include('profile-following-only')
</x-profile>