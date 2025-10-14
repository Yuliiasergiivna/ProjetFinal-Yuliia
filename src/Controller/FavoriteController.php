<?php

namespace App\Controller;

use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorites')]
    public function index(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
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
