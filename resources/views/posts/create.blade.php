@extends('layout')

@section('content')

<div class="container">
    <h2>Add Blog Post (basic) form</h2>
    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        @include('posts._form')

        <button type="submit" class="btn btn-primary btn-block">{{__('Create!')}} </button>
    </form>
</div>
      
@endsection