@extends('layout')

@section('content')
    <h1 class="title m-b-md">Contact</h1>
    <p class="text">This is Contact</p>

    @can('home.secret')
        <p>
        	<a href="{{ route('secret') }}" title="">Go to Special Contact Links</a>
        </p>
    @endcan
@endsection
    
