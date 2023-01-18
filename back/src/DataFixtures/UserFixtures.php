<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pwd = '$2y$13$xRLZ0dJJEJQP9Tw3wH5wvOWe2wVLMFkjGDOHXuEctFp7aBKrfC3K6'; //user

        $object = (new User())
            ->setEmail('user@user.fr')
            ->setUsername('user')
            ->setPassword($pwd)
            ->setRoles(['ROLE_USER'])
        ;
        $manager->persist($object);


        $object = (new User())
            ->setEmail('moderator@user.fr')
            ->setUsername('moderator')
            ->setPassword($pwd)
            ->setRoles(['ROLE_MODERATOR'])
        ;
        $manager->persist($object);


        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setUsername('admin')
            ->setPassword($pwd)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($object);

        $manager->flush();
    }
}
