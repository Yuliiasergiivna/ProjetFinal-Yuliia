<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comment;
use Faker\Factory;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_BE");
        for($i = 1; $i <= 5; $i++){
        $comment = new Comment();
        $comment->setText($faker->text(100));
        $comment->setDate(new \DateTime());

        
        $manager->persist($comment);
        $manager->flush();
    }
}
}