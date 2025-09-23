<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AjaxContollerController extends AbstractController
{
    #[Route('/ajax/contoller/form/independant', name: 'app_ajax_contoller')]
    public function index(): Response
    {
        return $this->render('ajax_contoller/form_independant.html.twig', [
            
        ]);
    }
    #[Route('/ajax/contoller/form/independant/traitement', name: 'app_ajax_contoller_form_independant_traitement')]
    public function formIndependantTraitement(Request $request): Response
    {
        $nom = $request->request->get('nom');
        $vars = ['message' => 'Bonjour ' . $nom,
                'nom' => $nom];
        return new JsonResponse($vars);

    }
}
