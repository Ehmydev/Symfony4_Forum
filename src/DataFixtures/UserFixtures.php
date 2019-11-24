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
        $ranks = $manager->getRepository(Rank::class)->findAll();

        $user = new User();
<<<<<<< HEAD
        $user->setLogin('Pipaul620')
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->setMail('oui@oui.fr')
=======
        $user->setLogin("pipaul620")
            ->setPassword($this->encoder->encodePassword($user,"admin"))
            ->setMail("oui@oui.fr")
>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
            ->addRank($ranks[0])
            ->addRank($ranks[1])
        ;

<<<<<<< HEAD
        $user2 = new User();
        $user2->setLogin('Ehmydev')
            ->setPassword($this->encoder->encodePassword($user2, 'user'))
            ->setMail('oui@oui.fr')
            ->addRank($ranks[0])
        ;

        $manager->persist($user);
        $manager->persist($user2);
=======
        $manager->persist($user);
>>>>>>> 84f10b5d59b15bcaf45015c9fed2102d2455e00d
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
        return 3;
    }
}
