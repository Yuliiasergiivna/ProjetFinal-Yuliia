<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Attraction;




class CategorieFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void

    {
        $attractions = $manager->getRepository(Attraction::class)->findAll();

        $categories = [
            ['name' => 'Nature', 'description' => 'Photos de paysages naturels, forêts, montagnes, etc.'],
            ['name' => 'Catedrale', 'description' => 'Photos de catedrales et batiments religieux'],
            ['name' => 'Espace romantique', 'description' => 'Photos de espaces romantiques'],
            ['name' => 'Châteaux', 'description' => 'Photos de châteaux'],
            ['name' => 'Villes', 'description' => 'Photos de villes']
        ];

        foreach ($categories as $i => $catData) {
            $category = new Category();
            $category->setName($catData['name']);
            $category->setDescription($catData['description']);

            $filtred = array_filter($attractions, fn($a)=> $a->getType() === $catData['type']);
            foreach ($filtred as $attraction) {
                $category->addAttraction($attraction);
            }
            $attractions = array_values($filtred);
          

            // if (!empty($attractions)) {
            //     $category->addAttraction($attractions[array_rand($attractions)]);
            // }
           
            $manager->persist($category);
            $this->addReference("category" . ($i + 1), $category );
        }

        $manager->flush();
    }
    
    
}
