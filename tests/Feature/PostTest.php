<?php

namespace Tests\Feature;

use App\BlogPost;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeetext('Nothing to show here!');
    }

    public function testSeeOneBlogPostWhenThereIsOne()
    {
        // Arrange Part
        $post = $this->createDummyBlogPost();

        // Act Part
        $response = $this->get('/posts');

        // Assert Part
        $response->assertSeetext('New Title');

        $this->assertDatabaseHas('blog_posts', [
            'title'=> 'New Title'
        ]);
    }

    // Testing Store Method
    public function testStoreValid()
    {
        // Arrange Part
        $params = [
            'title' => 'Title valid',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was created succesfully!');
    }

    // Testing Store/Fail Method
    public function testStoreFail()
    {
        // Arrange Part
        $params = [
            'title' => 'Test',
            'content' => 'Min'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 5 characters.');

        //dd($messages->getMessages());
    }

    // Testing Update
    public function testUpdateValid()
    {
        // Arrange Part
        $post = $this->createDummyBlogPost();
 
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]);

        // param we want to modify for test
        $params = [
            'title' => 'A New named Title',
            'content' => 'Content Was Changed'
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), 'Blog post was Updated!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title'=> 'A New named Title'
        ]);
    }

    // Testing Delete
    public function testDelete()
    {
        $post = $this->createDummyBlogPost();

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost(): BlogPost
    {
        // Arrange Part
        $post = new BlogPost();
        $post->title = 'New Title';
        $post->content = 'Content of the Blog';
        $post->save();

        return $post;
    }

}
