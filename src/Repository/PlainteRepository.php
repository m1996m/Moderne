<?php

namespace App\Repository;

use App\Entity\Plainte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Plainte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plainte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plainte[]    findAll()
 * @method Plainte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlainteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plainte::class);
    }

    // /**
    //  * @return Plainte[] Returns an array of Plainte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Plainte
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
