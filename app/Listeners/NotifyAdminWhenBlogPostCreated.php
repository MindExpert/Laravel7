<?php

namespace App\Listeners;

use App\User;
use App\Mail\BlogPostAdded;
use App\Events\BlogPostPostedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminWhenBlogPostCreated
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostPostedEvent $event)
    {
        User::isAdmin()->get()->map(function (User $user) use ($event) {
            Mail::to($user)->queue(
                new BlogPostAdded($event->blogPost)
            );
        });
    }
}
