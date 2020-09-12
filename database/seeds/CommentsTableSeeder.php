<?php

use App\User;
use App\Comment;
use App\BlogPost;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();

        if ($posts->count() === 0) {
            $this->command->info('There are No BlogPosts, No comments will be added!');
            return;
        }

        $allUsers = User::all();
        $commentsCount = (int)$this->command->ask('How many comments would you like?', 150);


        factory(Comment::class, $commentsCount)->make()->each( function($comment) use ($posts, $allUsers) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->user_id = $allUsers->random()->id;
            $comment->save();
        }); 
    }
}
