<?php

namespace App\DataFixtures;

use App\Entity\Attraction;
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
            $photo->setUrl($faker->imageUrl(640, 480));
            $manager->persist($photo);
            $attraction=$this->getReference("attraction".rand(1,5), Attraction::class);
            $photo->setAttraction($attraction);
        }

        $manager->flush();
    }
}