@extends('layout')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="">Name</label>
            <input type="text" required 
                name="name" 
                value="{{ old('name') }}"
                class="form-control {{ $errors->has('name') ? 'is-invalid': '' }}" 
            >
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>
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
        <div class="form-group">
            <label for="">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection