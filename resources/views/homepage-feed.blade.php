<x-layout>

    <div class="container py-md-5 container--narrow">

      @unless ($posts->isEmpty())
        <h2 class="text-center mb-4">Ultimos Posts de usuarios seguidos</h2>
        <div class="list-group">
          @foreach ($posts as $post)
              <x-post :post="$post" />
          @endforeach
        </div>

        <div class="mt-4">
          {{$posts->links()}}
        </div>
      @else
        <div class="text-center">
          <h2>Hello <strong>{{auth()->user()->username}}</strong>, feed vacía.</h2>
          <p class="lead text-muted">Sigue a más personas o utiliza el buscador para encontrar posts.</p>
        </div>
      @endunless
        
    </div>

</x-layout>