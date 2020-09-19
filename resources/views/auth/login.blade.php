@extends('layout')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="email" required
                name="email" 
                value="{{ old('email') }}" 
                class="form-control {{ $errors->has('email') ? 'is-invalid': '' }}" 
            >
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" required
                name="password" 
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" 
            >
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>
        <div class="form-controll">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember" value=" {{ old('remember') ? 'checked' : '' }}">
                <label for="remember" class="form-check-label">{{__('Remember Me!')}}</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
    </form>
@endsection