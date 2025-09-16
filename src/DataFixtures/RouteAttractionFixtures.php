<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\RouteAttraction;
use Faker\Factory;
use App\Entity\Route;
use App\Entity\Attraction;

class RouteAttractionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_BE");
        
        // Get all routes and attractions
        $routes = $manager->getRepository(Route::class)->findAll();
        $attractions = $manager->getRepository(Attraction::class)->findAll();      
        
        for($i = 1; $i <= 5; $i++) {
            $routeAttraction = new RouteAttraction();
            
            // Set random route and attraction from the existing ones
            $route = $faker->randomElement($routes);
            $attraction = $faker->randomElement($attractions);
            
            $routeAttraction->setRoute($route);
            $routeAttraction->setAttraction($attraction);
            
            // Set some fake data for other fields
            $routeAttraction->setName('RouteAttraction ' . $i);
            $routeAttraction->setDescription($faker->sentence());
            
            $manager->persist($routeAttraction);
        }
        $manager->flush();
    }
}
