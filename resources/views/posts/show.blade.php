@extends('layout')

@section('content')
    <h1 class="title m-b-md">Greating from the - {{ $post->title }}!</h1>
        @component('components.badge', ['type' => 'primary', 'show' => now()->diffInMinutes($post->created_at) < 180])
            New Post!
        @endcomponent
    <p class="text"> {{ $post->content }}</p>

    @component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name])
    @endcomponent

    @component('components.updated', ['date' => $post->updated_at])
        Updated
    @endcomponent

    {{-- <x-badge type="primary" message="New Post" :show="now()->diffInMinutes($post->created_at)<18" /> --}}

    <h4>COMMENTS</h4>
    @forelse ($post->comments as $comment)
        <p class="text"> 
            {{ $comment->content }}
        </p>

        @component('components.updated', ['date' => $comment->created_at])
        @endcomponent

    @empty
        <p class="text">No Comments Yet to Show</p>
    @endforelse

@endsection