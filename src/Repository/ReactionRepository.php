<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Reaction;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Reaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reaction[]    findAll()
 * @method Reaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reaction::class);
    }

    /**
     * @return Reaction[] Returns an array of Reaction objects
     */
    public function findByMessageAndUser(Message $message, User $user)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.message = :message AND r.user = :user')
            ->setParameter('message', $message)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Reaction[] Returns an array of Reaction objects
     */
    public function findByMessageAndType(Message $message, bool $type)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.message = :message AND r.type = :type')
            ->setParameter('message', $message)
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()
        ;
    }
}
