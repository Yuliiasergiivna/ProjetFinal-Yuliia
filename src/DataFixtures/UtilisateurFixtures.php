<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Utilisateur;


class UtilisateurFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
       for ($i = 1; $i <= 5; $i++) {
           $utilisateur = new Utilisateur();
           $utilisateur->setEmail('user' . $i . '@gmail.com');
        //    $utilisateur->setRoles(['ROLE_USER']);
           $utilisateur->setPassword($this->hasher->hashPassword($utilisateur, 'password' . $i));
           $manager->persist($utilisateur);
       }
        $manager->flush();
    }
}
