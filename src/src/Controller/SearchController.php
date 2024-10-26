<?php
namespace App\Controller;

use App\Form\SearchType;
use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private $client;
    private MovieService $movieService;

    public function __construct(HttpClientInterface $client, MovieService $movieService)
    {
        $this->client = $client;
        $this->movieService = $movieService;
    }

    #[Route('/search', name: 'app_search', methods: ['POST'])]
    public function search(Request $request): Response
    { 
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        
        $results = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Fetch the search query from the form
           $query = $form->get('query')->getData();
           $results = $this->movieService->searchMovie($query);  
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('search/_results.html.twig', [
                'results' => $results,
            ]);
        }

        // Render the full search form for inclusion in the base template
        return $this->render('search/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}

