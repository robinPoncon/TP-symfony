<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Beer;
use App\Entity\Country;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class BeerFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        // on fixe le nombre de bière à insérer dans les variables d'environnements
        $count = $_ENV["APP_FIXTURES_NB_BEERS"] ?? 20;

        $countries = $manager->getRepository(Country::class)->findAll();
        $categoryNormals = $manager->getRepository(Category::class)->findByTerm("normal");
        $categorySpecials = $manager->getRepository(Category::class)->findByTerm("special");

        $nbSpecials = count($categorySpecials);
        
        while($count > 0){
            shuffle($countries); // mélange le tableau par référence
            shuffle($categoryNormals);
            shuffle($categorySpecials);
            $beer = new Beer();
            $beer->setName($faker->word);
            $beer->setPublishedAt($faker->dateTime());
            $beer->setDescription($faker->text(rand(200, 500)));
            $beer->setPrice($faker->randomFloat(2, 4, 30));
            // dump($country);
            $beer->setCountry($countries[0]);
            $beer->addCategory($categoryNormals[0]);
            // En ajoute de manière aléatoire
            foreach(array_slice($categorySpecials, 0, rand(1, $nbSpecials)) as $catSpecial) {
                $beer->addCategory($catSpecial);
            }
            $count--;
            $manager->persist($beer);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}