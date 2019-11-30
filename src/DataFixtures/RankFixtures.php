<?php

namespace App\DataFixtures;

use App\Entity\Rank;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RankFixtures extends Fixture implements OrderedFixtureInterface
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
        $faker = Factory::create('fr_FR');

        $rank = new Rank();
        $rank->setName('ROLE_USER');
        $rank->setLibRank('Utilisateur');
        $rank->setColor('blue');
        $rank2 = new Rank();
        $rank2->setName('ROLE_ADMIN');
        $rank2->setLibRank('Administrateur');
        $rank2->setColor('red');

        $manager->persist($rank2);
        $manager->persist($rank);

        for ($i = 0; $i < 5; ++$i) {
            $rank = new Rank();
            $nameRank = $faker->word;
            $rank->setName('ROLE_'.strtoupper($nameRank));
            $rank->setLibRank($nameRank);
            $rank->setColor($faker->hexColor);
            $manager->persist($rank);
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
        return 2;
    }
}
