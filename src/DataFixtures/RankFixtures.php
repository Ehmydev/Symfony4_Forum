<?php

namespace App\DataFixtures;

use App\Entity\Rank;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RankFixtures extends Fixture implements OrderedFixtureInterface
{
<<<<<<< HEAD
=======

>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
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
        $rank = new Rank();
        $rank->setName('ROLE_USER');
        $rank2 = new Rank();
        $rank2->setName('ROLE_ADMIN');

        $manager->persist($rank);
        $manager->persist($rank2);
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
        return 2;
    }
}
