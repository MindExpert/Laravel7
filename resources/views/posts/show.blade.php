@extends('layout')

@section('content')
<div class="row">
    
    <div class="col-8">

        @if ($post->image)
            <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-position: center; background-attachment: fixed">
                <h1 class="title" style="padding-top: 100px; text-shadow: 1px 2px #000">
        @else    
            <h1>
        @endif
            Greating from the - {{ $post->title }}! 
            @component('components.badge', ['type' => 'primary', 'show' => now()->diffInMinutes($post->created_at) < 45])
                New Post!
            @endcomponent
        @if ($post->image)
                </h1>
            </div>
        @else    
            </h1>
        @endif
            {{-- Same as the one above --}}
            <x-badge type="primary" :show="now()->diffInMinutes($post->created_at)<45">
                New Post Component!
            </x-badge>
        <p class="text"> {{ $post->content }}</p>

        {{-- <img src="{{ Storage::url($post->image->path)}}" alt=""> --}}
        {{-- <img src="{{ $post->image->url() }}" alt=""> --}}


    
        @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name])
        @endcomponent
    
        @component('components.updated', ['date' => $post->updated_at->diffForHumans()])
            Updated
        @endcomponent 
    
        @component('components.tags', ['tags' => $post->tags])
        @endcomponent
       
        <p class="text-muted">Currently read by: {{ $counter }} people!</p>
    
        <h4>COMMENTS</h4>

        @component('components.comment-form', ['route'=> route('posts.comments.store', ['post' => $post->id])])
        @endcomponent
        {{-- @include('comments._form') --}}

        @component('components.comment-list', ['comments' =>$post->comments])
        @endcomponent
        {{-- @forelse ($post->comments as $comment)
            <div class="mb-2 p-2" style="border: 1px solid #00d4ff; border-radius: 10px">

                <p class="text"> 
                    {{ $comment->content }}
                </p>
                @component('components.updated', ['date' => $comment->created_at->diffForHumans(), 'name' => $comment->user->name])
                @endcomponent
            </div>
        @empty
            <p class="text">No Comments Yet to Show</p>
        @endforelse --}}

    </div>

    <div class="col-4">
        @include('posts._activity')
    </div>

</div>
@endsection