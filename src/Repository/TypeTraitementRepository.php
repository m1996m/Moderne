<?php

namespace App\Repository;

use App\Entity\TypeTraitement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeTraitement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeTraitement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeTraitement[]    findAll()
 * @method TypeTraitement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeTraitementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTraitement::class);
    }

    // /**
    //  * @return TypeTraitement[] Returns an array of TypeTraitement objects
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
    public function findOneBySomeField($value): ?TypeTraitement
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
