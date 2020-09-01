@extends('layout')

@section('content')
    <h1 class="title m-b-md">Greating from the {{ $post->title }}!</h1>
    <p class="text"> {{ $post->content }}</p>
    <p class="text-muted">Added at:  {{ $post->created_at->diffForHumans() }}</p>

    

    @if ( (new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
        <strong>Post is New!</strong>
    @endif

    <h4>COMMENTS</h4>
    @forelse ($post->comments as $comment)
        <p class="text"> 
            {{ $comment->content }}
        </p>
        <p class="text-muted"> 
            added {{ $comment->created_at->diffForHumans() }}
        </p>
    @empty
        <p class="text">No Comments Yet to Show</p>
    @endforelse

@endsection