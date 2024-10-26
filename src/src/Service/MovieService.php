<?php

namespace App\Service;

use Exception;
use RuntimeException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieService
{
    private HttpClientInterface $client;
    private string $apiKey;
    private string $apiUrl;

    public function __construct(HttpClientInterface $client, string $apiKey, string $apiUrl)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Fetches movie details by movie Id .
     */
    public function getMovie(int $movieId): array
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf($this->apiUrl . '3/movie/%d', $movieId),
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]
            );

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Handle transport errors (network issues, etc.)
            throw new RuntimeException('Network error occurred: ' . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            // Handle client errors (4xx responses)
            throw new RuntimeException('Client error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            // Handle server errors (5xx responses)
            throw new RuntimeException('Server error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            // Handle any other exceptions
            throw new RuntimeException('An unexpected error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Get movie's genre
     */
    public function getMoviesGenre(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrl . '3/genre/movie/list',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]
            );

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Handle transport errors (network issues, etc.)
            throw new RuntimeException('Network error occurred: ' . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            // Handle client errors (4xx responses)
            throw new RuntimeException('Client error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            // Handle server errors (5xx responses)
            throw new RuntimeException('Server error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            // Handle any other exceptions
            throw new RuntimeException('An unexpected error occurred: ' . $e->getMessage());
        }
    }


    public function getBestMovie(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrl . '3/movie/top_rated',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]
            );

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Handle transport errors (network issues, etc.)
            throw new RuntimeException('Network error occurred: ' . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            // Handle client errors (4xx responses)
            throw new RuntimeException('Client error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            // Handle server errors (5xx responses)
            throw new RuntimeException('Server error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            // Handle any other exceptions
            throw new RuntimeException('An unexpected error occurred: ' . $e->getMessage());
        }
    }


    /**
     * get Movie lists
     */
    public function getMovieList(): array
    {
        try {
            $results = [];
            $response = $this->client->request(
                'GET',
                $this->apiUrl . '3/movie/popular',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]
            );

            $lists = $response->toArray()['results'];
            return $this->getMovieDetails($lists);
        } catch (TransportExceptionInterface $e) {
            // Handle transport errors (network issues, etc.)
            throw new RuntimeException('Network error occurred: ' . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            // Handle client errors (4xx responses)
            throw new RuntimeException('Client error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            // Handle server errors (5xx responses)
            throw new RuntimeException('Server error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            // Handle any other exceptions
            throw new RuntimeException('An unexpected error occurred: ' . $e->getMessage());
        }
    }


    public function getMovieDetails(array $lists) : array
    {

        foreach ($lists as $list) {
            $detailResponse = $this->client->request(
                'GET',
                sprintf($this->apiUrl . '3/movie/%d', $list['id']),
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]
            );

            $detail = $detailResponse->toArray();

            $results[] = [
                'id' => $list['id'],
                'release_date' => $list['release_date'],
                'original_title' => $list['original_title'],
                'title' => $list['title'],
                'vote_count' => $list['vote_count'],
                'backdrop_path' => $list['backdrop_path'],
                'overview' => $list['overview'],
                'production_companies' => $detail['production_companies'],
                'tagline' => $detail['tagline'],


            ];
        }
        return $results;
    }
    public function searchMovie(string $value): array
    {
        try {
            
            $response = $this->client->request(
                'GET',
                $this->apiUrl . '3/search/movie',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'query' => ['query' => urlencode($value)],
                ]
            );

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Handle transport errors (network issues, etc.)
            throw new RuntimeException('Network error occurred: ' . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            // Handle client errors (4xx responses)
            throw new RuntimeException('Client error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            // Handle server errors (5xx responses)
            throw new RuntimeException('Server error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            // Handle any other exceptions
            throw new RuntimeException('An unexpected error occurred: ' . $e->getMessage());
        }
    }


    public function filterByGenre(string $ids): array
    {
        try {
            
            $response = $this->client->request(
                'GET',
                $this->apiUrl . '3/discover/movie',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'query' => ['with_genres' =>  $ids],
                ]
            );
            
            $lists = $response->toArray();
            return $this->getMovieDetails($lists['results']);
        } catch (TransportExceptionInterface $e) {
            // Handle transport errors (network issues, etc.)
            throw new RuntimeException('Network error occurred: ' . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            // Handle client errors (4xx responses)
            throw new RuntimeException('Client error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            // Handle server errors (5xx responses)
            throw new RuntimeException('Server error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            // Handle any other exceptions
            throw new RuntimeException('An unexpected error occurred: ' . $e->getMessage());
        }
    }


    public function getMovieVideos($id): array
    {
        try { 
            $response = $this->client->request(
                'GET',
                sprintf($this->apiUrl . '3/movie/%d/videos', $id),
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]
            );

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Handle transport errors (network issues, etc.)
            throw new RuntimeException('Network error occurred: ' . $e->getMessage());
        } catch (ClientExceptionInterface $e) {
            // Handle client errors (4xx responses)
            throw new RuntimeException('Client error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            // Handle server errors (5xx responses)
            throw new RuntimeException('Server error occurred: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            // Handle any other exceptions
            throw new RuntimeException('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
