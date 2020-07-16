@extends('layout')

@section('content')

<div class="container">
    <h2>Edit Blog Post</h2>
    <form action="{{ route('posts.update' , ['post'=> $post->id ]) }}" method="post">
        @csrf
        @method('PUT')

        @include('posts._form')
        
        <button type="submit" class="btn btn-primary btn-block">Update! </button>
    </form>
</div>
      
@endsection