<?php

namespace App\DataFixtures;

use App\Entity\Rank;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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
        $ranks = $manager->getRepository(Rank::class)->findAll();

        $user = new User();
        $user->setLogin("pipaul620")
            ->setPassword($this->encoder->encodePassword($user,"admin"))
            ->setMail("oui@oui.fr")
            ->addRank($ranks[0])
            ->addRank($ranks[1])
        ;

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
