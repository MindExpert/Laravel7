<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}" name="title" value="{{ old('title', $post->title ?? null) }}" placeholder="Ttile">
    {{-- @if ($errors->has('title'))
        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
    @endif --}}
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="content">Content</label>
    <input type="text" class="form-control {{ $errors->has('content') ? 'is-invalid' : ''}}" name="content" value="{{ old('content', $post->content ?? null) }}" placeholder="Content">
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="content">Thumbnail</label>
    <input type="file" class="form-control-file {{ $errors->has('thumbnail') ? 'is-invalid' : ''}}" name="thumbnail">
    @error('thumbnail')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@component('components.errors')
@endcomponent