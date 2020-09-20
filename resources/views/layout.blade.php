<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">


    </head>
    <body>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5>
            <nav class="nav my-2 my-md-0 mr-md-3">
                <a href="{{ route('home') }}"> @lang('Home') </a>
                <a href="{{ route('contact') }}"> @lang('Contact') </a>
                <a href="{{ route('posts.index') }}"> @lang('Blog Posts') </a>
                <a href="{{ route('posts.create') }}"> @lang('Add') </a>        
                @guest
                    <a href="{{ route('login') }}">@lang('Login')</a> 
                    @if (Route::has('register'))
                            <a href="{{ route('register') }}">@lang('Register')</a>
                    @endif 
                @else
                    <a href="{{ route('users.show', ['user' => Auth::user()->id]) }}">
                        @lang('Profile')
                    </a> 
                    <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}">
                        @lang('Edit Profile')
                    </a>  
                    <form 
                        action="{{ route('logout') }}" 
                        method="post" 
                        id="logout-form"
                        style="display: none"
                    >
                        @csrf

                    </form>
                    <a 
                        href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); 
                        document.getElementById('logout-form').submit()"
                    > @lang('Logout') ({{ Auth::user()->name}}) </a> 

                @endguest
            </nav>
        </div>

        <div class="container">
            
            @if (session()->has('status'))
                <p style="color:red;">
                    {{ session()->get('status') }}
                </p>
            @endif  

            @yield('content')
                
        </div>
 
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
