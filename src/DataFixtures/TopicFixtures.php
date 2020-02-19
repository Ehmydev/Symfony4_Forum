<?php

namespace App\DataFixtures;

use App\Entity\SubCategory;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class TopicFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $subcategories = $manager->getRepository(SubCategory::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 1000; ++$i) {
            $topic = new Topic();
            $topic
                ->setCreatedAt($faker->dateTime('now'))
                ->setTitle($faker->words(rand(4, 16), true))
                ->setUser($users[rand(0, sizeof($users) - 1)])
                ->setMessage($faker->realText(1000))
                ->setSubCategory($faker->randomElement($subcategories))
                ->setPin(false);

            $manager->persist($topic);
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
        return 4;
    }
}
