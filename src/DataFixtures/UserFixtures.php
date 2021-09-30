<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user2 = new User();
        $user1->setEmail("test@yopmail.com");
        $user2->setEmail("test2@yopmail.com");
        $user1->setRoles(["ROLE_VISITOR"]);
        $user2->setRoles(["ROLE_VISITOR", "ROLE_ADMIN"]);
        // ...

        $user1->setPassword($this->passwordHasher->hashPassword(
            $user1,
            '123'
        ));

        $user2->setPassword($this->passwordHasher->hashPassword(
            $user2,
            '123'
        ));

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
        // ...
    }

    public function getOrder() {
        return 3;
    }
}
