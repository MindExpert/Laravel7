@extends('layout')

@section('content')
    <h1 class="title m-b-md">Greating from the - {{ $post->title }}!</h1>
        @component('components.badge', ['type' => 'primary', 'show' => now()->diffInMinutes($post->created_at) < 45])
            New Post!
        @endcomponent
        {{-- Same as the one below --}}
        <x-badge type="primary" :show="now()->diffInMinutes($post->created_at)<45">
            New Post Component!
        </x-badge>
    <p class="text"> {{ $post->content }}</p>

    @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name])
    @endcomponent

    @component('components.updated', ['date' => $post->updated_at->diffForHumans()])
        Updated
    @endcomponent 
   

    <h4>COMMENTS</h4>
    @forelse ($post->comments as $comment)
        <p class="text"> 
            {{ $comment->content }}
        </p>
        @component('components.updated', ['date' => $comment->created_at->diffForHumans()])
        @endcomponent
    @empty
        <p class="text">No Comments Yet to Show</p>
    @endforelse

@endsection