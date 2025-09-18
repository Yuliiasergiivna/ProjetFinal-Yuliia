<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Utilisateur;
use Faker\Factory;


class UtilisateurFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
       for ($i = 1; $i <= 5; $i++) {
           $utilisateur = new Utilisateur();
           $utilisateur->setEmail('user' . $i . '@gmail.com');
           $utilisateur->setNom('user' . $i);

           $utilisateur->setDateNaissance($faker->dateTimeBetween('-80 years', '-18 years'));
           $utilisateur->setRoles(['ROLE_USER']);
           $utilisateur->setPassword($this->hasher->hashPassword($utilisateur, 'password' . $i));
           $manager->persist($utilisateur);
       }
        for ($i = 1; $i <= 5; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail('admin' . $i . '@gmail.com');
            $utilisateur->setNom('admin' . $i);

            $utilisateur->setDateNaissance($faker->dateTimeBetween('-80 years', '-18 years'));
            $utilisateur->setRoles(['ROLE_ADMIN']);
            $utilisateur->setPassword($this->hasher->hashPassword($utilisateur, 'password' . $i));
            $manager->persist($utilisateur);
    }
    $manager->flush();
}
    }