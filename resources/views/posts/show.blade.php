@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
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
    
        @component('components.tags', ['tags' => $post->tags])
        @endcomponent
       
        <p class="text-muted">Currently read by: {{ $counter }} people!</p>
    
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
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
</div>

@endsection