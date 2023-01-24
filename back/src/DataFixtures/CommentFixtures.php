<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $forums = $manager->getRepository(Forum::class)->findAll();

        $faker = Factory::create('fr_FR');
        
        for ($nbArticle=0; $nbArticle < 20; $nbArticle++) { 
            $object = (new Comment())
                ->setForum($faker->randomElement($forums))
                ->setContent($faker->paragraph(10, true))
                ->setCreatedBy($faker->randomElement($users))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now')))
            ;
            $manager->persist($object);   
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ForumFixtures::class,
        ];
    }
}
