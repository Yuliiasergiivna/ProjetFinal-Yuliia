<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Favorite;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Attraction;

class FavoriteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create ("fr_BE");
        for($i = 1; $i <= 5; $i++){
        $favorite = new Favorite();
       
        
        $manager->persist($favorite);
        $manager->flush();
    }
}
}
