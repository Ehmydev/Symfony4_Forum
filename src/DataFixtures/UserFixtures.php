<?php

namespace App\DataFixtures;

use App\Entity\Rank;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        /** @var Rank[] $ranks */
        $ranks = $manager->getRepository(Rank::class)->findAll();

        $user = new User();
        $user->setLogin('Pipaul620')
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->setMail('oui@oui.fr')
            ->addRank($ranks[0])
            ->addRank($ranks[1])
        ;

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; ++$i) {
            $user2 = new User();
            $user2->setLogin($faker->userName)
                ->setPassword($this->encoder->encodePassword($user2, 'user'))
                ->setMail($faker->email)
                ->setAbout($faker->words(rand(5, 10), true))
                ->setLocation($faker->city)
                ->addRank($ranks[rand(1, sizeof($ranks) - 1)])
            ;
            $manager->persist($user2);
        }

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
