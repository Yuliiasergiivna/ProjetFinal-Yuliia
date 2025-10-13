<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use Faker\Factory;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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
            $this->addReference("category" . ($i + 1), $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
