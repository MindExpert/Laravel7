@extends('layout')

@section('content')

    <div class="row">
        <div class="col-8">
        @forelse ($posts as $post) 
            <ul>
                <h3>
                    @if ($post->trashed())
                    <del>
                    @endif
                    <a class="{{$post->trashed() ? 'text-muted' : ''}}" href="{{ route('posts.show' , ['post' => $post->id]) }}">
                        {{ $post->title }}
                    </a>
                    @if ($post->trashed())
                    </del>
                    @endif
                </h3>

                @if ($post->comments_count)
                    <p class="text"> {{ $post->comments_count}} comments  </p>               
                @else
                    <p class="text">No Comments yet</p>
                @endif


                {{-- They all do the same thing --}}

                {{-- <p class="text-muted"> 
                    Added: {{ $post->created_at->diffForHumans() }} </br>
                    by: {{ $post->user->name }}
                </p> --}}

                @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name])
                @endcomponent
                
                {{-- <x-updated :name="$post->user->name" :date="$post->created_at->diffForHumans()">
                    Testing
                </x-updated> --}}
                


                @auth    
                    @can('update', $post)
                        {{-- <p class="text">{{ $post->content }} </p> --}}
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit!</a>
                    @endcan
                @endauth

                @auth
                    @if (!$post->trashed())
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy' , ['post'=> $post->id ]) }}" method="post" class="fm-inline">
                                @csrf
                                @method('DELETE')                    
                                <button  type="submit" class="btn btn-primary">delete </button>
                            </form>
                        @endcan
                    @endif
                @endauth

                @cannot('delete', $post)
                    <p class="text-muted"> 
                        Can't Delete this post
                    </p>
                @endcannot
            </ul>

        @empty
            <p class="text">Nothing to show here!</p>  
        @endforelse 
        </div>

        <div class="col-4">
            <div class="container">

                <div class="row">
                    @component('components.card', ['title'=> 'Most Commented'])
                        @slot('subtitle')
                            What people are currently talking about
                        @endslot
                        @slot('items')
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        @endslot
                    @endcomponent
                </div>

                <div class="row row mt-4">
                    @component('components.card', ['title'=> 'Most Active'])
                        @slot('subtitle')
                            User with most poste written
                        @endslot
                        @slot('items', collect($mostActive)->pluck('name'))
                    @endcomponent
                </div>

                <div class="row row mt-4">
                    @component('components.card', ['title'=> 'Most Active Last Month'])
                        @slot('subtitle')
                            Users with most posts written in the last month
                        @endslot
                        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                    @endcomponent
                </div>

            </div>
        </div>
    </div>
@endsection