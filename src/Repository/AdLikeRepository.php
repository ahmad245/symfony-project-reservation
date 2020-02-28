<?php

namespace App\Repository;

use App\Entity\AdLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdLike[]    findAll()
 * @method AdLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdLike::class);
    }

    // /**
    //  * @return AdLike[] Returns an array of AdLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdLike
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
