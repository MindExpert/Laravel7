@extends('layout')

@section('content')
    <form method="post" enctype="multipart/form-data"
        action="{{ route('users.update', ['user' => $user->id]) }}" 
        class="form-horizontal"
    >
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : ''}}" alt="" class="img-thumbnail avatar">                
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>{{__('Upload a different photo')}}</h6>
                        <input type="file" class="form-control-file" name="avatar"/>
                        @error('avatar')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="">{{__('Name:')}}</label>
                    <input type="text" value="" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" name="name" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">{{__('Language:')}}</label>
                    <select name="locale" class="form-control">
                        @foreach (App\User::LOCALES as $locale =>$label)
                            <option value="{{ $locale}}" {{ $user->locale !== $locale ?: 'selected'}}>
                                {{$label}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save changes') }}</button>
                </div>                
            </div>
        </div>
    </form>
@endsection