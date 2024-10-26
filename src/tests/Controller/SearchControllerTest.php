<?php

namespace App\Tests\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SearchControllerTest extends WebTestCase
{
    private $client;
    private $movieService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the MovieService
        $this->movieService = $this->createMock(MovieService::class);

        // Create a client to simulate HTTP requests
        $this->client = static::createClient();
    }

    public function testSearchFormIsRendered(): void
    {
        // Send a GET request to the /search route
        $this->client->request('GET', '/search');

        // Assert that the response status code is 200 OK
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Assert that the search form is present in the response
        $this->assertSelectorExists('form'); 
    }

    protected function tearDown(): void
    {
        // Reset client or other dependencies
        parent::tearDown();
        $this->client = null;
    }
}
