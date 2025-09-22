<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comment;
use Faker\Factory;
use App\Entity\Utilisateur;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_BE");
        for ($i = 1; $i <= 5; $i++) {
            $comment = new Comment();
            $comment->setText($faker->text(100));
            $comment->setDate(new \DateTime());
            $comment->setUtilisateur($this->getReference('utilisateur' . rand(1, 5), Utilisateur::class));


            $manager->persist($comment);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
        ];
    }
}
