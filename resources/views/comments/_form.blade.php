<h2>Add Blog Post (basic) form</h2>
<form action="{{ route('posts.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}" name="title" value="{{ old('title', $post->title ?? null) }}" placeholder="Ttile">
        {{-- @if ($errors->has('title'))
            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
        @endif --}}
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea type="text" 
            class="form-control" 
            name="content" 
            placeholder="Comment Content"
        >
        </textarea>
    </div>
    

    <button type="submit" class="btn btn-primary btn-block">Add Comment! </button>
</form>