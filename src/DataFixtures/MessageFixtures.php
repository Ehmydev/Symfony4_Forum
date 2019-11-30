<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class MessageFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $topics = $manager->getRepository(Topic::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 10000; ++$i) {
            $message = new Message();
            $message
                ->setCreatedAt($faker->dateTime('now'))
                ->setUser($users[rand(0, sizeof($users) - 1)])
                ->setMessage($faker->realText(1000))
                ->setTopic($faker->randomElement($topics))
            ;
            $manager->persist($message);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }
}
