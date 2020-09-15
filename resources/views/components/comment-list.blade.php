@forelse ($comments as $comment)
    <div class="mb-2 p-2" style="border: 1px solid #00d4ff; border-radius: 10px">

        <p class="text"> 
            {{ $comment->content }}
        </p>
        @component('components.updated', ['date' => $comment->created_at->diffForHumans(), 'name' => $comment->user->name, '$comment->user->id'])
        @endcomponent
    </div>
@empty
    <p class="text">No Comments Yet to Show</p>
@endforelse