<?php

namespace App\DataFixtures;

use App\Entity\Clip;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClipFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();

        for ($nbClip=0; $nbClip < 20; $nbClip++) { 
            $object = (new Clip())
                ->setTitle($faker->sentence(6, true))
                ->setPath('https://www.youtube.com/watch?v=QH2-TGUlwu4')
                ->setUploadedBy($faker->randomElement($users))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now')))
            ;
            $manager->persist($object);   
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
