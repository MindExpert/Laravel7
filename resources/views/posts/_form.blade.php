<div class="form-group">
    <label for="title">{{__('Title')}}</label>
    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}" name="title" value="{{ old('title', $post->title ?? null) }}" placeholder="{{__('Title')}}">
    {{-- @if ($errors->has('title'))
        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
    @endif --}}
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="content">{{__('Content')}}</label>
    <input type="text" class="form-control {{ $errors->has('content') ? 'is-invalid' : ''}}" name="content" value="{{ old('content', $post->content ?? null) }}" placeholder="{{__('Content')}}">
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="content">{{__('Thumbnail')}}</label>
    <input type="file" name="thumbnail" class="form-control-file {{ $errors->has('thumbnail') ? 'is-invalid' : ''}}">
    @error('thumbnail')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@component('components.errors')
@endcomponent