<?php

namespace App\Controller;

use App\Entity\Attraction;
use App\Repository\AttractionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        return $this->render('accueil/index.html.twig');
        // dd($this->getUser());
        //obtenir tous les elements du cote 1:
        // $repo=$entityManager->getRepository(Attraction::class);
        // $attractions=$repo->findAll();
        // $vars=['attractions'=>$attractions];



        return $this->render('accueil/index.html.twig');
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


    #[Route('/api/attractions', name: 'api_attractions', methods: ['GET'])]
    public function getAttractions(AttractionRepository $repository): JsonResponse
    {
        $attractions = $repository->findAll();

        $data = [];
        foreach ($attractions as $attraction) {
            // Get first photo for each attraction if available
            $photos = $attraction->getPhotos();
            $image = $photos->count() > 0 ? $photos->first()->getUrl() : null;

            // Get category name if available
            $category = $attraction->getCategory();
            $categoryName = $category ? $category->getName() : null;

            $data[] = [
                'id' => $attraction->getId(),
                'name' => $attraction->getName(),
                'description' => $attraction->getDescription(),
                'latitude' => (float) $attraction->getLatitude(),
                'longitude' => (float) $attraction->getLongitude(),
                'category' => $categoryName,
                'route' => $attraction->getRoute(),
                'image' => $image,
            ];
        }

        return new JsonResponse($data);
    }
}