<?php

namespace App\DataFixtures;

use App\Entity\Tournament;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TournamentFixtures extends Fixture
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
                ->setCreatedBy($faker->randomElement($users))
                //->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween( , 'now')))
            ;
            $manager->persist($object);   
        }

        $manager->flush();   
    }
}
