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
            
            {{-- <p class="text">{{ $post->content }} </p> --}}
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit!</a>

                <form action="{{ route('posts.destroy' , ['post'=> $post->id ]) }}" method="post" class="fm-inline">
                    @csrf
                    @method('DELETE')                    
                    <button  type="submit" class="btn btn-primary">delete </button>
                </form>
        </ul>

    @empty
        <p class="text">Nothing to show here!</p>  
    @endforelse 

@endsection

