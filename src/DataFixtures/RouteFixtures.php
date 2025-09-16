<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Route;
use Faker\Factory;

class RouteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_BE");
        for($i = 1; $i <= 5; $i++){
            $route = new Route();
            $route->setName($faker->word());
            $route->setDescription($faker->text(100));
            $manager->persist($route);
        }
        $manager->flush();
    }
}
