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
        $blogCount = (int)$this->command->ask('How Many Blog Posts would you like?', 50);
        $allUsers = User::all();
        
        factory(BlogPost::class, $blogCount)->make()->each( function($post) use ($allUsers) {
            $post->user_id = $allUsers->random()->id;
            $post->save();
        });
    }
}
