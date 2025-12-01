<?php

namespace App\Controller;

use App\Entity\Attraction;
use App\Entity\Category;
use App\Repository\AttractionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse; // Import JsonResponse
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
    #[Route('/categories/{id}/attractions', name: 'app_category_attractions')]
    public function showByCategory(Category $category): Response
    {
        $attractions = $category->getAttractions();

        return $this->render('attraction/by_category.html.twig', [
            'category' => $category,
            'attractions' => $attractions,
        ]);
    }
        /**
     * API endpoint to return all attractions as JSON for the map.
     * * @param AttractionRepository $attractionRepository
     * @return JsonResponse
     */
    #[Route('/api/attractions', name: 'api_attractions', methods: ['GET'])]
    public function getAllAttractionsJson(AttractionRepository $attractionRepository): JsonResponse
    {
        // Используем findAllWithPhotos() из репозитория, чтобы убедиться, что мы получаем все данные.
        // Если findAllWithPhotos() не существует или возвращает только Attraction, то нужно использовать findAll().
        // Для демонстрации будем использовать findAll() и добавим явную выборку.
        $attractions = $attractionRepository->findAll();
        
        $data = [];
        foreach ($attractions as $attraction) {
            /** @var Attraction $attraction */
            
            // Получаем название категории, если она установлена
            $categoryName = $attraction->getCategory() ? $attraction->getCategory()->getName() : null;
            
            // Получаем URL первой фотографии. Метод getPhoto() в Entity\Attraction это делает.
            $photoUrl = $attraction->getPhoto(); 
            // В map.js мы ожидаем только имя файла, а не полный URL, 
            // поэтому здесь мы передадим только имя, если photoUrl содержит его.
            // Предположим, что getPhoto() возвращает имя файла (например, 'image.jpg')
            // Если getPhoto() возвращает полный путь, вам нужно будет изменить map.js или логику здесь.
            // Судя по getPhoto(): public function getPhoto(): ?string { ... return $photo->getUrl(); }
            // URL может быть полным путем, но map.js ожидает: `/uploads/photos/${attraction.image}`
            // Поэтому я буду использовать Url как 'image'
            
            $data[] = [
                'id' => $attraction->getId(),
                'name' => $attraction->getName(),
                'latitude' => $attraction->getLatitude(),
                'longitude' => $attraction->getLongitude(),
                // Ключевое изменение: передаем название категории
                'category' => $categoryName, 
                // Передаем имя файла изображения, как ожидает map.js (attraction.image)
                'image' => $photoUrl, 
            ];
        }

        return $this->json($data);
    }
}
