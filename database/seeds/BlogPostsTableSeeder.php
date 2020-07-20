<?php

use App\User;
use App\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allUsers = User::all();
        factory(BlogPost::class, 50)->make()->each( function($post) use ($allUsers) {
            $post->user_id = $allUsers->random()->id;
            $post->save();
        });
    }
}
