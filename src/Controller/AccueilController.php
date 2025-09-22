<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Attraction;
use Symfony\Component\HttpFoundation\Request;


final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // dd($this->getUser());
        //obtenir tous les elements du cote 1:
        // $repo=$entityManager->getRepository(Attraction::class);
        // $attractions=$repo->findAll();
        // $vars=['attractions'=>$attractions];


        $adresse=['rue'=>'rue de la paix',
        'numero'=>12,
        'codePostal'=>'75001', ];

        dd($adresse);
        $vars = ['nom' => 'Yuliia',
        'hobby' => 'natation',
        'dateNaissance' => new \DateTime('2005-09-15'),
        'adresse'=>$adresse];

        // dd($vars);


        return $this->render('accueil/index.html.twig', $vars);
    }
     #[Route('/accueil/testModele')]
    public function testModele(EntityManagerInterface $entityManager)

    {
        $repo=$entityManager->getRepository(Attraction::class);
        $arrayAttractions=$repo->findAll();

        $arrayAttractions[0]->getCategories();

        // $arrayAttractions=$entityManager->getRepository(Attraction::class)->findAll();

        dd($arrayAttractions);
        $vars=[
            'attractions'=>$arrayAttractions
        ];
        return $this->render('accueil/test_modele.html.twig',$vars );
    }
    // #[Route('/accueil/testModele/{id_attraction}', name: 'app_test_modele')] 
    // public function testModeleAttraction(Request $request, EntityManagerInterface $entityManager): Response
    // {
    // $id_attraction=$request->get('id_attraction');
    // $attraction=$entityManager->getRepository(Attraction::class)->find($id_attraction);
    // $vars=['attraction'=>$attraction];
    // return $this->render('accueil/test_modele_attraction.html.twig',$vars );
    // }
}
