<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Attraction;
use Faker\Factory;
use App\Entity\Category;
use App\DataFixtures\CategorieFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\Common\Collections\Collection;

class AttractionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void

    {
        $faker = Factory::create("fr_BE");

        //  // Определяем ключи категорий, которые вы создали в CategorieFixtures
        // // В CategorieFixtures вы использовали: $this->addReference("category" . ($i + 1), $category );
        // $categoryReferences = [
        //     $this->getReference("category1", Category::class), // Nature
        //     $this->getReference("category2", Category::class), // Catedrale
        //     $this->getReference("category3", Category::class), // Espace romantique
        //     $this->getReference("category4", Category::class), // Châteaux
        //     $this->getReference("category5", Category::class), // Villes
        // ];

        // for($i = 1; $i <= 15; $i++){
        //     $attraction = new Attraction();
        //     $attraction->setName("Lieu Touristique " . $i . ": " . $faker->city);
        //     $attraction->setDescription($faker->text(250));
        //         // Добавим фото, чтобы избежать ошибок, если оно требуется
        //     $photo = new Photo();
        //     $photo->setName($attraction->getName());
        //     $photo->setUrl("randomPhoto" . $i . ".jpg");
        //     $attraction->addPhoto($photo);
        //     $manager->persist($photo);

            
        //     // Предполагаем, что у вас есть поле latitude/longitude в Attraction:
        //     $attraction->setLatitude($faker->latitude);
        //     $attraction->setLongitude($faker->longitude);
            
        //     // Предполагаем, что у вас есть setRoute:
        //     // Внимание: Route должен быть сущностью Route, но здесь вы используете float/int.
        //     // Если Route это просто число, оставляем так:
        //     $attraction->setRoute('attraction/random-'.$i); 
            
        //     // 1. Выбираем случайную категорию из списка ссылок
        //     $randomCategory = $categoryReferences[array_rand($categoryReferences)];
            
        //     // 2. Устанавливаем привязку (самый важный шаг)
        //     $attraction->setCategory($randomCategory);
            
        //     $manager->persist($attraction);
        //     $this->addReference("random_attraction" . $i, $attraction);
        //     $attraction = new Attraction();
        //     $attraction->setName("Île de Khortytsa".$i);
        //     $attraction->setDescription("Description de l'attraction".$i);
        //     $attraction->setRoute($faker->randomFloat(2, 0, 100));
        //     $manager->persist($attraction);
        //     $categorie=$this->getReference("category". rand(1,5), Category::class);
        //     $attraction->setCategory($categorie);
        //     $this->addReference("attraction".$i, $attraction);
            
         
         $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class,
        ];
    }
   
}
