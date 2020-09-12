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

        @include('comments._form')

        @forelse ($post->comments as $comment)
            <div class="mb-2 p-2" style="border: 1px solid #00d4ff; border-radius: 10px">

                <p class="text"> 
                    {{ $comment->content }}
                </p>
                @component('components.updated', ['date' => $comment->created_at->diffForHumans(), 'name' => $comment->user->name])
                @endcomponent
            </div>
        @empty
            <p class="text">No Comments Yet to Show</p>
        @endforelse
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
</div>

@endsection