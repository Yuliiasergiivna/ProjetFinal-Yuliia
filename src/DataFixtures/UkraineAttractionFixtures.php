<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Attraction;
use App\Entity\Photo;
use App\DataFixtures\CategorieFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class UkraineAttractionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        // Категории, которые можно использовать
        // 1: Nature, 2: Catedrale, 3: Espace romantique, 4: Châteaux, 5: Villes
        

        
        $attractions = [
            [
                'name' => "Place de l'Indépendance",
                'description' => "La place centrale de Kiev, symbole de l'indépendance de l'Ukraine.",
                'latitude' => '50.4501',
                'longitude' => '30.5234',
                'category_ref' => 5, // Villes
            ],
            [
                'name' => 'Laure des Grottes de Kiev',
                'description' => "Monastère orthodoxe historique classé au patrimoine mondial de l'UNESCO.",
                'latitude' => '50.4340',
                'longitude' => '30.5571',
                'category_ref' => 2, // Catedrale
            ],
            [
                'name' => 'Cathédrale Sainte-Sophie',
                'description' => "Un chef-d'œuvre d'architecture du XIe siècle, classé au patrimoine mondial de l'UNESCO.",
                'latitude' => '50.4529',
                'longitude' => '30.5149',
                'category_ref' => 2, // Catedrale
            ],
            [
                'name' => 'Rue Khreshchatyk',
                'description' => 'La rue principale de Kiev, connue pour son architecture et ses animations.',
                'latitude' => '50.4500',
                'longitude' => '30.5233',
                'category_ref' => 5, // Villes
            ],
            [
                'name' => "Opéra d'Odessa",
                'description' => "Un magnifique exemple d'architecture néo-baroque, l'un des plus beaux opéras d'Europe de l'Est.",
                'latitude' => '46.4850',
                'longitude' => '30.7406',
                 'category_ref' => 5, // Villes
            ],
            [
                'name' => 'Château de Kamianets-Podilskyï',
                'description' => 'Forteresse médiévale impressionnante située sur une île rocheuse.',
                'latitude' => '48.6736',
                'longitude' => '26.5853',
                'category_ref' => 4, // Châteaux
            ],
            [
                'name' => "Tunnel d'amour",
                'description' => 'Un tunnel végétal romantique formé par des arbres, populaire auprès des couples.',
                'latitude' => '51.2221',
                'longitude' => '25.7951',
                'category_ref' => 3, // Espace romantique
            ],
            [
                'name' => 'Île de Khortytsia',
                'description' => 'La plus grande île du Dniepr, berceau historique des cosaques zaporogues et réserve naturelle nationale.',
                'latitude' => '47.8388',
                'longitude' => '35.0869',
                'category_ref' => 1, // Nature
            ],
            [
                'name' => 'Parc Sofiyivka',
                'description' => "Magnifique parc paysager du XVIIIe siècle à Ouman, chef-d'œuvre de l'art des jardins européens.",
                'latitude' => '48.7608',
                'longitude' => '30.2231',
                'category_ref' => 1, // Nature
            ],
            [
                'name' => "Fontaines Roshen",
                'description' => "L'un des plus grands complexes de fontaines flottantes d'Europe.",
                'latitude' => '49.2331',
                'longitude' => '28.4682',
                'category_ref' => 5, // Villes
            ],
            [
                'name' => "Château de Lubart",
                'description' => "Forteresse médiévale emblématique du XIVe siècle.",
                'latitude' => '50.7398',
                'longitude' => '25.3274',
                'category_ref' => 4, // Châteaux
            ],
            [
                'name' => "Monastère de l'île Monastyrsky",
                'description' => "Un site historique sur une île pittoresque du Dniepr.",
                'latitude' => '48.4680',
                'longitude' => '35.0424',
                'category_ref' => 2, // Catedrale
            ],
            [
                'name' => "Sviatohirsk Lavra",
                'description' => "Monastère orthodoxe historique construit sur les falaises de craie.",
                'latitude' => '49.0370',
                'longitude' => '37.5666',
                'category_ref' => 2, // Catedrale
            ],
            [
                'name' => "Réserve naturelle de Striltsivsky Step",
                'description' => "L'un des plus anciens parcs naturels préservés d'Ukraine.",
                'latitude' => '49.3332',
                'longitude' => '39.5528',
                'category_ref' => 1, // Nature
            ],
            [
                'name' => "Opéra de Lviv",
                'description' => "Joyau architectural d\'Europe centrale construit en 1900.",
                'latitude' => '49.8440',
                'longitude' => '24.0263',
                'category_ref' => 5, // Villes
            ],
            [
                'name' => "Parc National Biloberezhia Svitiaz",
                'description' => "Réserve côtière unique au bord de la mer Noire.",
                'latitude' => '46.6000',
                'longitude' => '31.3000',
                'category_ref' => 1, // Nature
            ],
            [
                'name' => "Cathédrale de la Transfiguration",
                'description' => "L'un des plus beaux monuments religieux de la région.",
                'latitude' => '50.9077',
                'longitude' => '34.7981',
                'category_ref' => 2, // Catedrale
            ],
            [
                'name' => "Biosphère d'Askania-Nova",
                'description' => "Réserve de steppe mondiale unique classée par l'UNESCO.",
                'latitude' => '46.4500',
                'longitude' => '33.8650',
                'category_ref' => 1, // Nature
            ],
            [
                'name' => "Université de Tchernivtsi",
                'description' => "Complexe architectural historique inscrit à l'UNESCO.",
                'latitude' => '48.2915',
                'longitude' => '25.9393',
                'category_ref' => 5, // Villes
            ],
            [
                'name' => "Monastère de la Transfiguration",
                'description' => "L'un des plus anciens monastères slaves orientaux.",
                'latitude' => '51.4937',
                'longitude' => '31.2990',
                'category_ref' => 2, // Catedrale
            ],
            [
                'name' => "Nid d'Hirondelle",
                'description' => "Château emblématique perché sur une falaise surplombant la mer Noire.",
                'latitude' => '44.4305',
                'longitude' => '34.1140',
                'category_ref' => 4, // Châteaux
            ],
            [
                'name' => "Chersonèse Taurique",
                'description' => "Ancienne cité grecque, site archéologique inscrit au patrimoine mondial de l'UNESCO.",
                'latitude' => '44.6118',
                'longitude' => '33.4905',
                'category_ref' => 4, // Châteaux
            ],
            [
                'name' => 'Lac Synevyr',
                'description' => 'Le plus grand lac de montagne d\'Ukraine, situé dans le parc national Synevyr, souvent appelé la “perle des Carpates”.',
                'latitude' => '48.6220',
                'longitude' => '23.6896',
                'category_ref' => 1, // Nature
            ],
            [
                'name' => 'Montagnes des Carpates',
                'description' => "Une vaste chaîne de montagnes couvrant l'ouest de l'Ukraine, connue pour ses paysages pittoresques, ses traditions hutsoles et ses sentiers de randonnée.",
                'latitude' => '48.2650',
                'longitude' => '24.4880',
                'category_ref' => 1, // Nature
            ],

        ];

        for ($i =0 ; $i<count($attractions) ;$i++) {
            $attraction = new Attraction();
            $attraction->setName($attractions[$i]['name']);
            $attraction->setDescription($attractions[$i]['description']);
            $attraction->setLatitude($attractions[$i]['latitude']);
            $attraction->setLongitude($attractions[$i]['longitude']);

            // create and add photo
            $photo = new Photo();
            $photo->setName($attractions[$i]['name']);
            $photo->setUrl( "photoInit" .$i .".jpg");
            $attraction->addPhoto($photo);
            $manager->persist($photo);


            // $attraction->setRoute('attraction/' . strtolower(str_replace(' ', '-', $attractions[$i]['name'])));
            
            // creer la reference a l'attraction
            $this->addReference("attraction".$i, $attraction);            
            
            // obtenir une reference de categorie
            $category=$this->getReference("category".$attractions[$i]['category_ref'] , Category::class);
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
