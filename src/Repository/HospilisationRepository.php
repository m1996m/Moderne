<?php

namespace App\Repository;

use App\Entity\Hospilisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hospilisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hospilisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hospilisation[]    findAll()
 * @method Hospilisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospilisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hospilisation::class);
    }

    // /**
    //  * @return Hospilisation[] Returns an array of Hospilisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hospilisation
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
