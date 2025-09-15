<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class MonController extends AbstractController
{
    #[Route('/mon', name: 'app_mon')]
    public function index(): Response
    {
        return $this->render('mon/index.html.twig', [
            'controller_name' => 'MonController',
        ]);
    }
        // L'objet Request rajouté dans la signature de l'action contiendra les données
    // de la requête faite au serveur. En ce qui nous concerne maintenant,il 
    // contiendra les valeurs des paramètres de l'URL.

    #[Route("/contacts/message/request/{prenom}/{profession}")]
    public function messageRequest(Request $objetRequest)
    {
        echo "Je suis dans le controller, action 'afficher'";
        // on obtient les valeurs des paramètres de l'url,
        // on fait appel à la méthode get de l'objet Request
        $lePrenom = $objetRequest->get("prenom");
        $laProfession = $objetRequest->get("profession");
        return new Response("<br>Le prénom dans l'URL est:" . $lePrenom . "<br>La profession dans l'URL est:" . $laProfession);
    }
}
