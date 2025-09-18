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
        $faker = Factory::create("fr_BE");
        for($i = 1; $i <= 5; $i++){
            $category = new Category();
            $category->setName($faker->word());
            $category->setDescription($faker->text(100));
            $this->addReference("category".$i, $category);

            $manager->persist($category);

        }

        $manager->flush();
    }
}
