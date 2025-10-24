<?php

namespace App\Controller;

use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\FavoriteType;

final class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorites')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {

        $formFavorite = $this->createForm(FavoriteType::class);
        $formFavorite->handleRequest($request);

        if($formFavorite->isSubmitted()){
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        }
        if($formFavorite->isSubmitted() && ($formFavorite->isValid())){
            $favoriteEntity = $formFavorite->getData();
            $em->persist($favoriteEntity);
            $em->flush();
            $this->addFlash('success', 'Attraction ajoutée aux favoris !');
            return $this->redirectToRoute('app_favorites');
        }
      
        
        $user = $this->getUser();
        
        // Получаем все избранные достопримечательности текущего пользователя
        $favorites = $em->getRepository(Favorite::class)->findBy(
            ['utilisateur' => $user],
            ['date' => 'DESC']
        );
        
        return $this->render('favorite/index.html.twig', [
            'favorites' => $favorites,
        ]);
    }
}
