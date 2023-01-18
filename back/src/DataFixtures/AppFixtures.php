<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $pwd = '$2y$13$xRLZ0dJJEJQP9Tw3wH5wvOWe2wVLMFkjGDOHXuEctFp7aBKrfC3K6'; //user

        $object = (new User())
            ->setEmail('user@user.fr')
            ->setUsername('user')
            ->setPassword($pwd)
            ->setRoles(['ROLE_USER'])
        ;
        $manager->persist($object);


        $object = (new User())
            ->setEmail('manager@user.fr')
            ->setUsername('manager')
            ->setPassword($pwd)
            ->setRoles(['ROLE_MANAGER'])
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

        $manager->flush();
    }
}
