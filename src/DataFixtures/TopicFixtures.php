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
        $user = $manager->getRepository(User::class)->findAll()[0];

<<<<<<< HEAD
        for ($i = 0; $i < 100; ++$i) {
            $topic = new Topic();
            $topic
                ->setCreatedAt($faker->dateTime('now'))
                ->setTitle($faker->words(rand(4, 16), true))
=======
        for ($i = 0; $i < 1000; $i++){
            $topic = new Topic();
            $topic
                ->setCreatedAt($faker->dateTime('now'))
                ->setTitle($faker->words(rand(4,16),true))
>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
                ->setUser($user)
                ->setMessage($faker->realText(1000))
                ->setSubCategory($faker->randomElement($subcategories))
            ;
            $manager->persist($topic);
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
        return 4;
    }
}
