<?php

namespace App\DataFixtures;

use App\Entity\Tournament;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TournamentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();

        $faker = Factory::create('fr_FR');
        
        for ($nbArticle=0; $nbArticle < 20; $nbArticle++) { 
            $deadline = $faker->dateTimeBetween('now', '+1 year');
            $object = (new Tournament())
                ->setMaxPlayers($faker->numberBetween(4, 16))
                ->setParticipationDeadline(\DateTimeImmutable::createFromMutable($deadline))
                ->setStartAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween($deadline, '+1 year')))
                ->setName($faker->sentence(6, true))
                ->setIsFree($faker->boolean(75))
                ->setIsOver($faker->boolean(50))
                ->setCreatedBy($faker->randomElement($users))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 years' , '-1 month')))
            ;
            $manager->persist($object);   
        }

        $manager->flush(); 
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
