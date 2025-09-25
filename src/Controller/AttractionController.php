<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AttractionController extends AbstractController
{
    #[Route('/attraction', name: 'app_attraction')]
    public function index(): Response
    {
        return $this->render('attraction/index.html.twig', [
            // $formAttraction = $this->createForm(AttractionType::class);

        ]);
    }
}
