<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\YoutubeStatistics;

class YoutubeFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        /**
         * Добавить Elastic search index
         */

        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Faker\Provider\Youtube($faker));
        $date = new \DateTimeImmutable();

        for ($i=1; $i < 1000; $i++) {

            $like = rand(0, 1000);
            $disLike = rand(0, 1000);

            $youtubeStatistics = new YoutubeStatistics();
            $youtubeStatistics->setUrl($faker->youtubeUri());
            $youtubeStatistics->setLike($like);
            $youtubeStatistics->setDislike($disLike);
            $youtubeStatistics->setCreated($date);
            $youtubeStatistics->setUpdated($date);
            $manager->persist($youtubeStatistics);
            $manager->flush();
        }


    }

    public static function getGroups(): array
    {
        return ['youtube'];
    }
}
