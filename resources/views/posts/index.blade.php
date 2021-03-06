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

                {{-- @if ($post->comments_count)
                    <p class="text"> {{ $post->comments_count}} comments  </p>               
                @else
                    <p class="text">No Comments yet</p>
                @endif --}}
                {{ trans_choice('messages.comments', $post->comments_count)}}


                {{-- They all do the same thing --}}

                {{-- <p class="text-muted"> 
                    Added: {{ $post->created_at->diffForHumans() }} </br>
                    by: {{ $post->user->name }}
                </p> --}}

                @component('components.updated', ['date' => $post->created_at->diffForHumans(), 'name' => $post->user->name, 'userId' => $post->user->id])
                @endcomponent

                @component('components.tags', ['tags' => $post->tags])
                @endcomponent
                
                {{-- <x-updated :name="$post->user->name" :date="$post->created_at->diffForHumans()">
                    Testing
                </x-updated> --}}
                


                @auth    
                    @can('update', $post)
                        {{-- <p class="text">{{ $post->content }} </p> --}}
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">{{__('Edit')}}</a>
                    @endcan
                @endauth

                @auth
                    @if (!$post->trashed())
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy' , ['post'=> $post->id ]) }}" method="post" class="fm-inline">
                                @csrf
                                @method('DELETE')                    
                                <button  type="submit" class="btn btn-primary">{{__('Delete!')}}</button>
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
            <p class="text">{{__('No blog posts yet!')}}</p>  
        @endforelse 
        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
@endsection