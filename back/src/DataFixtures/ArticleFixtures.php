<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $moderators = $manager->getRepository(User::class)->findAll();
        
        for ($nbArticle=0; $nbArticle < 20; $nbArticle++) { 
            $object = (new Article())
                ->setTitle($faker->sentence(6, true))
                ->setContent($faker->randomHtml(2, 3))
                ->setCreatedBy($faker->randomElement($moderators))
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
