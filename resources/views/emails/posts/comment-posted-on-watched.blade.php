@component('mail::message')
# Comment Was posted on post you are watching

Hello {{ $user->name}}

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
