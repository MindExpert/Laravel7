<div class="mb-2 mt-2">
    @auth 
        <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="post">
            @csrf
            <div class="form-group">
                <label for="content">Content</label>
                <textarea type="text" 
                    class="form-control {{ $errors->has('content') ? 'is-invalid' : ''}}"" 
                    name="content" 
                    placeholder="Comment Content"
                ></textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Comment! </button>
        </form>
        {{-- @component('components.errors')
        @endcomponent --}}
    @else
        <a href="{{ route('login') }}">Sign IN</a> to post a comment
    @endauth
</div>
<hr/>