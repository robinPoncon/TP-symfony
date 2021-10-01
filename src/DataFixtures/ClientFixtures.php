<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ClientFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $users = $manager->getRepository(User::class)->findAll();

        foreach($users as $user) {
            $client = new Client();
            $client->setEmail($user->getEmail());
            $client->setWeight($faker->randomFloat(2, 30, 150));
            $client->setName($faker->firstName());
            $client->setAge($faker->numberBetween(18, 100));
            $client->setUser($user);
            $manager->persist($client);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}