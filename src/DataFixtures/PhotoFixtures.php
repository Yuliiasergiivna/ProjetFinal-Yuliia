<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Photo;
use Faker\Factory;
use DateTime;

class PhotoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_BE');
        for ($i=0; $i < 100; $i++) { 
            $photo = new Photo();
            $photo->setName($faker->word);
            $photo->setDateUpload(new DateTime());
            $manager->persist($photo);
        }

        $manager->flush();
    }
}