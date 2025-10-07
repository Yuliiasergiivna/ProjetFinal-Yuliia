<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Favorite;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Attraction;
use App\DataFixtures\AttractionFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FavoriteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_BE");
        for ($i = 1; $i <= 5; $i++) {
            $favorite = new Favorite();
            $attraction = $this->getReference("attraction" . rand(0, 7), Attraction::class);
            $favorite->setAttraction($attraction);



            $manager->persist($favorite);
            $manager->flush();
        }
    }
    public function getDependencies(): array
    {
        return [
            AttractionFixtures::class,
            UkraineAttractionFixtures::class,
        ];
    }
}
