<?php

namespace App\Repository;

use App\Entity\Ordonnance;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ordonnance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordonnance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordonnance[]    findAll()
 * @method Ordonnance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdonnanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordonnance::class);
    }

    // /**
    //  * @return Ordonnance[] Returns an array of Ordonnance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ordonnance
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function mesOrdonnances(User $patient): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('e')
        ->join('e.consultation', 'consultation')
        ->join('e.traitement', 'traitement')
        ->where('traitement.patient =:patient')
        ->ORwhere('consultation.patient =:patient')
        ->setParameters(['patient'=>$patient, 'patient'=>$patient] )
        ->orderBy('e.id', 'DESC');

        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }
}
