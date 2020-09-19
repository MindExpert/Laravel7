@component('mail::message')
# Someone Has Posted a Blog Post

Be sure to proof red it

@component('mail::button', ['url' => route('posts.show', ['post'=> $blogPost->id]) ])
View - {{ $blogPost->title }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
