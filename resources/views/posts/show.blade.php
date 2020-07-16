@extends('layout')

@section('content')
    <h1 class="title m-b-md">Greating from the {{ $post->title }}!</h1>
    <p class="text"> {{ $post->content }}</p>
    <p class="text">Added at:  {{ $post->created_at->diffForHumans() }}</p>

    

    @if ( (new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
        <strong>Post is New!</strong>
    @endif
@endsection