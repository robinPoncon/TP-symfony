<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Country;
use Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        $faker = Faker\Factory::create("fr_FR");

        // for ($i = 0; $i < 3; $i++) {
        //     $country = new Country();
        //     $country->setName($faker->country());
        //     $country->setAddress($faker->address());

        //     for ($j = 0; $j < 5; $j++) {
        //         $beer = new Beer();
        //         $beer->setName($faker->name());
        //         $beer->setDescription($faker->text());
        //         $beer->setPublishedAt($faker->datetime());
        //         $beer->setPrice($faker->randomNumber(2));

        //         $manager->persist($beer);

        //         $country->addBeer($beer);
        //     }

        //     $manager->persist($country);
        // }
        $manager->flush();
    }
}
