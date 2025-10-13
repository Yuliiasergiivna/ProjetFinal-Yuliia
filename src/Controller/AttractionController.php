<?php

namespace App\Controller;

use App\Entity\Attraction;
use App\Repository\AttractionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AttractionController extends AbstractController
{
    #[Route('/attraction', name: 'app_attraction')]
    public function index(AttractionRepository $attractionRepository): Response
    {
        $attractions = $attractionRepository->findAllWithPhotos();
        
        return $this->render('attraction/index.html.twig', [
            'attractions' => $attractions,
        ]);
    }
    
    #[Route('/attraction/{id}', name: 'app_attraction_show')]
    public function show(Attraction $attraction): Response
    {
        return $this->render('attraction/show.html.twig', [
            'attraction' => $attraction,
        ]);
    }
}
