<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Attraction;
use App\DataFixtures\CategorieFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Photo;

class UkraineAttractionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {






        
        $attractions = [
            [
                'name' => 'Place de l\'Indépendance',
                'description' => 'La place centrale de Kiev, symbole de l\'indépendance de l\'Ukraine.',
                'latitude' => '50.4501',
                'longitude' => '30.5234',
                'city' => 'Kiev',
            ],
            [
                'name' => 'Laure des Grottes de Kiev',
                'description' => 'Monastère orthodoxe historique classé au patrimoine mondial de l\'UNESCO.',
                'latitude' => '50.4340',
                'longitude' => '30.5571',
                'city' => 'Kiev',
            ],
            [
                'name' => 'Cathédrale Sainte-Sophie',
                'description' => 'Un chef-d\'œuvre d\'architecture du XIe siècle, classé au patrimoine mondial de l\'UNESCO.',
                'latitude' => '50.4529',
                'longitude' => '30.5149',
                'city' => 'Kiev',
            ],
            [
                'name' => 'Rue Khreshchatyk',
                'description' => 'La rue principale de Kiev, connue pour son architecture et ses animations.',
                'latitude' => '50.4500',
                'longitude' => '30.5233',
                'city' => 'Kiev',
            ],
            [
                'name' => 'Opéra d\'Odessa',
                'description' => 'Un magnifique exemple d\'architecture néo-baroque, l\'un des plus beaux opéras d\'Europe de l\'Est.',
                'latitude' => '46.4850',
                'longitude' => '30.7406',
                'city' => 'Odessa',
            ],
            [
                'name' => 'Château de Kamianets-Podilskyï',
                'description' => 'Forteresse médiévale impressionnante située sur une île rocheuse.',
                'latitude' => '48.6736',
                'longitude' => '26.5853',
                'city' => 'Kamianets-Podilskyï',
            ],
            [
                'name' => 'Tunnel d\'amour',
                'description' => 'Un tunnel végétal romantique formé par des arbres, populaire auprès des couples.',
                'latitude' => '51.2221',
                'longitude' => '25.7951',
                'city' => 'Klevan',
            ],
            [
                'name' => 'Île de Khortytsia',
                'description' => 'La plus grande île du Dniepr, berceau historique des cosaques zaporogues et réserve naturelle nationale.',
                'latitude' => '47.8388',
                'longitude' => '35.0869',
                'city' => 'Zaporijjia',
            ],
            [
                'name' => 'Parc Sofiyivka',
                'description' => 'Magnifique parc paysager du XVIIIe siècle à Ouman, chef-d\'œuvre de l\'art des jardins européens.',
                'latitude' => '48.7608',
                'longitude' => '30.2231',
                'city' => 'Ouman',
            ]
        ];

        for ($i =0 ; $i<count($attractions) ;$i++) {
            $attraction = new Attraction();
            $attraction->setName($attractions[$i]['name']);
            $attraction->setDescription($attractions[$i]['description']);
            $attraction->setLatitude($attractions[$i]['latitude']);
            $attraction->setLongitude($attractions[$i]['longitude']);

            // create and add photo
            $photo = new Photo($attractions[$i]['name'], new \DateTime(), "photoInit" .$i .".jpg");
            $attraction->addPhoto($photo);
            

            $attraction->setRoute('attraction/' . strtolower(str_replace(' ', '-', $attractions[$i]['name'])));
            
            // creer la reference a l'attraction
            $this->addReference("attraction".$i, $attraction);            
            
            // obtenir une reference de categorie
            $category=$this->getReference("category". rand(1,5), Category::class);
            $attraction->setCategory($category);

            $manager->persist($attraction);
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class,
        ];
    }
}
