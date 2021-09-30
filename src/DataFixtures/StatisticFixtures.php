<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Beer;
use App\Entity\Client;
use App\Entity\Category;
use App\Entity\Statistic;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class StatisticFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $clients = $manager->getRepository(Client::class)->findAll();
        $beers = $manager->getRepository(Beer::class)->findAll();
        $categories = $manager->getRepository(Category::class)->findAll();

        $clientsId = [];
        $beersId = [];
        $categoriesId = [];

        $nbClients = count($clients) -1;
        $nbBeers = count($beers) -1;
        $nbCategories = count($categories) -1;
        foreach($clients as $client) {
            array_push($clientsId, $client->getId());
        }
        foreach($beers as $beer) {
            array_push($beersId, $beer->getId());
        }
        foreach($categories as $category) {
            array_push($categoriesId, $category->getId());
        }
        for ($i = 0; $i < 15; $i++) {
            $stat = new Statistic();
            $randomIdClient = $clientsId[random_int(0, $nbClients)];
            $randomClient = $manager->getRepository(Client::class)->find($randomIdClient);
            $randomIdBeer = $beersId[random_int(0, $nbBeers)];
            $randomBeer = $manager->getRepository(Beer::class)->find($randomIdBeer);

            $stat->setClientId($randomClient);
            $stat->setBeerId($randomBeer);
            $stat->setCategoryId($categoriesId[random_int(0, $nbCategories)]);
            $stat->setScore(random_int(0, 20));

            $manager->persist($stat);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}