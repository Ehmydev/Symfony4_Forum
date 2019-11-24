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

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ranks = $manager->getRepository(Rank::class)->findAll();

        $user = new User();
        $user->setLogin('Pipaul620')
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->setMail('oui@oui.fr')
            ->addRank($ranks[0])
            ->addRank($ranks[1])
        ;

        $user2 = new User();
        $user2->setLogin('Ehmydev')
            ->setPassword($this->encoder->encodePassword($user2, 'user'))
            ->setMail('oui@oui.fr')
            ->addRank($ranks[0])
        ;

        $manager->persist($user);
        $manager->persist($user2);
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
