<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $countries = ['belgium', 'french', 'English', 'germany'];

        foreach($countries as $name){
            $country = new Country();
            $country->setName($name);

            $manager->persist($country);
        }

        $manager->flush();
    }

    public function getOrder(){

        return 1;
    }
}