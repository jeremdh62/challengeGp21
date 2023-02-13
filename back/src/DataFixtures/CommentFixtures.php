<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Forum;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();
        $forums = $manager->getRepository(Forum::class)->findAll();
        
        for ($nbComment=0; $nbComment < 20; $nbComment++) { 
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
