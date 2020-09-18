@component('mail::message')
# Coment was posted on your blogpost

Hello {{ $comment->commentable->user->name}}

Someone has commented on your blog post

@component('mail::button', ['url' => route('posts.show', ['post'=> $comment->commentable->id]) ])
View the BlogPost {{ $comment->commentable->title }}
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user'=> $comment->user->id]) ])
Visit {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
