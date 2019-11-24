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
        $user = $manager->getRepository(User::class)->findAll()[0];

<<<<<<< HEAD
        for ($i = 0; $i < 500; ++$i) {
=======
        for ($i = 0; $i < 10000; $i++){
>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
            $message = new Message();
            $message
                ->setCreatedAt($faker->dateTime('now'))
                ->setUser($user)
                ->setMessage($faker->realText(1000))
                ->setTopic($faker->randomElement($topics))
            ;
            $manager->persist($message);
        }

        $manager->flush();
    }

    /**
<<<<<<< HEAD
     * Get the order of this fixture.
     *
     * @return int
=======
     * Get the order of this fixture
     *
     * @return integer
>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
     */
    public function getOrder()
    {
        return 5;
    }
}
