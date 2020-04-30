<?php

namespace App\Repository;

use App\Entity\Articls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articls|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articls|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articls[]    findAll()
 * @method Articls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articls::class);
    }

    // /**
    //  * @return Articls[] Returns an array of Articls objects
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
    public function findOneBySomeField($value): ?Articls
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
