<?php

namespace App\Repository;

use App\Entity\SubCategory;
use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    public function findBySubCategoryQuery(SubCategory $subcat): Query
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.messages', 'm')->addSelect('m')
            ->leftJoin('t.user', 'u')->addSelect('u')
            ->leftJoin('m.user', 'u2')->addSelect('u2')
            ->andWhere('t.subCategory = :subcat')
            ->setParameter('subcat', $subcat)
            ->orderBy('t.pin', 'DESC')
            ->orderBy('t.created_at', 'DESC')
            ->getQuery();
    }

    public function findByNameQuery(string $search = ''): Query
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.messages', 'm')->addSelect('m')
            ->leftJoin('t.user', 'u')->addSelect('u')
            ->leftJoin('m.user', 'u2')->addSelect('u2')
            ->andWhere('t.title LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('t.pin', 'DESC')
            ->orderBy('t.created_at', 'DESC')
            ->getQuery();
    }

    // /**
    //  * @return Topic[] Returns an array of Topic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Topic
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
