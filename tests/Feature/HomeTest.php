<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{

    public function testHomePageIsWorking()
    {
        $response = $this->get('/');

        $response->assertSeeText('Home Page');
        $response->assertSeeText('This is the home page!');
    }

    public function testContactPageIsWorking()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
        $response->assertSeeText('This is Contact');
    }
}
