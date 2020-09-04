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
                @if (!$post->trashed())
                    @can('delete', $post)
                        <form action="{{ route('posts.destroy' , ['post'=> $post->id ]) }}" method="post" class="fm-inline">
                            @csrf
                            @method('DELETE')                    
                            <button  type="submit" class="btn btn-primary">delete </button>
                        </form>
                    @endcan
                @endif

                @cannot('delete', $post)
                    <p class="text-muted"> 
                        Can't Delete this post
                    </p>
                @endcannot
            </ul>

        @empty
            <p class="text">Nothing to show here!</p>  
        @endforelse 
        </div>
        <div class="col-4">
            <div class="container">
                <div class="row">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                              What people are currently talking about
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row row mt-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                              User with most poste written
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActive as $user)
                                <li class="list-group-item">
                                    <a href="#">
                                        {{ $user->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row row mt-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Last Month</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                              Users with most posts written in the last month
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActiveLastMonth as $user)
                                <li class="list-group-item">
                                    <a href="#">
                                        {{ $user->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection