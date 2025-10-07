<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Attraction;
use Faker\Factory;
use App\Entity\Category;
use App\DataFixtures\CategorieFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AttractionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void

    {
        // $faker = Factory::create("fr_BE");
        // for($i = 1; $i <= 5; $i++){
        //     $attraction = new Attraction();
        //     $attraction->setName("Île de Khortytsa".$i);
        //     $attraction->setDescription("Description de l'attraction".$i);
        //     $attraction->setRoute($faker->randomFloat(2, 0, 100));
        //     $manager->persist($attraction);
        //     $categorie=$this->getReference("category". rand(1,5), Category::class);
        //     $attraction->setCategory($categorie);
        //     $this->addReference("attraction".$i, $attraction);
            
        // }
        // $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class,
        ];
    }
}
