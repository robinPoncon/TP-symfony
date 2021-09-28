<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $categoriesNormals = ['blonde', 'brune', 'blanche']; 
        $categoriesSpecials = ['houblon', 'rose', 'menthe', 'grenadine', 'réglisse', 'marron', 'whisky', 'bio'];

        foreach ($categoriesNormals as $normal) {
            $category = new Category();
            $category->setName($normal);
            $category->setDescription($faker->text(rand(200, 500)));
            $category->setTerm("normal");

            $manager->persist($category);
        }

        foreach ($categoriesSpecials as $special) {
            $category = new Category();
            $category->setName($special);
            $category->setDescription($faker->text(rand(200, 500)));
            $category->setTerm("special");

            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}