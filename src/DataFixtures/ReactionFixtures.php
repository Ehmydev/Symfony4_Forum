<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Reaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ReactionFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $messages = $manager->getRepository(Message::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        foreach ($messages as $message) {
            for ($i = 0; $i < 5; ++$i) {
                $reaction = new Reaction();
                $reaction
                ->setUser($users[rand(0, sizeof($users) - 1)])
                ->setMessage($message)
                ->setType(rand(0, 1));

                $manager->persist($reaction);
            }
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
        return 6;
    }
}
