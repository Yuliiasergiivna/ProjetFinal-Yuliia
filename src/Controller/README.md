- MapController.php contient les routes pour afficher un exemple de carte contenant des points d'intérêt

MapController contient:

```php
    #[Route('/api/points-of-interest', name: 'api_points_of_interest', methods: ['GET'])]
    public function getPointsOfInterest(PointOfInterestRepository $repository): JsonResponse
```

C'est une action qui récupère tous les points d'intérêt de la base de données et les retourne au format JSON.
Ceci nous permet de les utiliser dans le template de la carte.



- Dans templates/map il y a une vue pour afficher la carte (contenant les points d'intérêt)
