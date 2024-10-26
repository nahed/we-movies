<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MoviesController extends AbstractController
{

    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    #[Route('/movies', name: 'app_movies')]
    public function index(Request $request): Response
    {
        $genres = $this->movieService->getMoviesGenre();
        $bestMovie = $this->movieService->getBestMovie();
        $videoBestMovie = $this->movieService->getMovieVideos($bestMovie['results'][0]['id']);
        $lists = $this->movieService->getMovieList();
        
        return $this->render('movie/list.html.twig', [
            'genres'    => $genres['genres'],
            'bestmovie' => $bestMovie['results'][0],
            'video'    =>  $videoBestMovie['results'][0],
            'lists'     => $lists ,
        ]);
    }

    #[Route('/movies/genre', name: 'app_movies_genre', methods:'GET')]
    public function genres(Request $request): Response
    {
        $genres = $this->movieService->getMoviesGenre();
        
        return $this->render('movie/filter.html.twig', [
            'genres'    => $genres['genres'],
        ]);
    }

    #[Route('/movies/genre/filter', name: 'app_movies_genre_filter', methods:'GET')]
    public function filterByGenre(Request $request): Response
    {
        $genres = $request->query->get('genres');
        $lists = $this->movieService->filterByGenre($genres);
        
        return $this->render('search/filtered.html.twig', [
            'lists'     => $lists ,
        ]);
    }


    #[Route('/movie/{id}', name: 'app_movie', methods:'GET')]
    public function show(int $id): Response
    {
        $movie = $this->movieService->getMovie($id);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/movie/{id}/videos/popup', name: 'app_movie_popup', methods:'GET')]
    public function popupMovie(int $id): Response
    {
        $movie = $this->movieService->getMovie($id);
        $videoData = $this->movieService->getMovieVideos($id);
        $videos = $videoData['results'][0] ?? [];

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
            'video' => $videos,
            'exclude_content' => true
        ]);
    }

}
