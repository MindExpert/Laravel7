@extends('layout')

@section('content')

    @forelse ($posts as $post) 
        <ul>
            <h3><a href="{{ route('posts.show' , ['post' => $post->id]) }}">{{ $post->title }}</a></h3>

            @if ($post->comments_count)
                <p class="text"> {{ $post->comments_count}} comments  </p>               
            @else
                <p class="text">No Comments yet</p>
            @endif

            <p class="text-muted"> 
                Added: {{ $post->created_at->diffForHumans()  }} </br>
                by: {{ $post->user->name }}
            </p>
            
            @can('update', $post)
                {{-- <p class="text">{{ $post->content }} </p> --}}
                <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit!</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy' , ['post'=> $post->id ]) }}" method="post" class="fm-inline">
                    @csrf
                    @method('DELETE')                    
                    <button  type="submit" class="btn btn-primary">delete </button>
                </form>
            @endcan
            @cannot('delete', $post)
                <p class="text-muted"> 
                    Can't Delete this post
                </p>
            @endcannot
            
        </ul>

    @empty
        <p class="text">Nothing to show here!</p>  
    @endforelse 

@endsection

