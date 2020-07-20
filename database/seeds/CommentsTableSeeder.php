<?php

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
        factory(Comment::class, 150)->make()->each( function($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        }); 
    }
}
