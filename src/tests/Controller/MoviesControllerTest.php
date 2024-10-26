<?php

namespace App\Tests\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MoviesControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        
    }

    public function testIndex(): void
    {
       $this->client->request('GET', '/movies');
       $this->assertResponseIsSuccessful();
       $this->assertResponseStatusCodeSame(Response::HTTP_OK);
       $this->assertSelectorExists('h1'); 
    }

    public function testGenres(): void
    {
        $this->client->request('GET', '/movies/genre');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.filter-section'); 
    }

    public function testFilterByGenre(): void
    {
        $this->client->request('GET', '/movies/genre/filter?genres=28');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.movie-item'); 
    }

    public function testShow(): void
    { 
        $this->client->request('GET', '/movie/278');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('h1'); 
    }

    public function testPopupMovie(): void
    {
        $this->client->request('GET', '/movie/278/videos/popup');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('iframe'); 
    }


    protected function tearDown(): void
    {
        // Reset client or other dependencies
        parent::tearDown();
        $this->client = null;
    }
}
