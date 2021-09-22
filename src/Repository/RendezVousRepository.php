<?php

namespace App\Repository;

use App\Entity\RendezVous;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @method RendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method RendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method RendezVous[]    findAll()
 * @method RendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    // /**
    //  * @return RendezVous[] Returns an array of RendezVous objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RendezVous
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function RENDEZVOUS(User $patient): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $date = new \DateTime();
        //$dates=DateTime::createFromFormat('Y-m-d',$date);
        $qb = $this->createQueryBuilder('p')
            ->where('p.medecin = :patient')
            ->andwhere('p.date =:date')
            ->setParameters(['patient'=> $patient,'date'=> $date->format('Y-m-d')])
            ->orderBy('p.id', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }
    public function rechercheRendezvous(User $patient): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        //$dates=DateTime::createFromFormat('Y-m-d',$date);
        $date = new \DateTime();
        $qb = $this->createQueryBuilder('p')
            ->where('p.medecin = :patient')
            ->andwhere('p.date =:date')
            ->setParameters(['patient'=> $patient,'date'=> $date->format('Y-m-d')])
            ->orderBy('p.id', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }

    public function mesrdv(User $user): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        //$dates=DateTime::createFromFormat('Y-m-d',$date);
        $date = new \DateTime();
        $qb = $this->createQueryBuilder('p')
            ->where('p.medecin =:user')
            ->orwhere('p.patient =:user')
            ->orwhere('p.date >:date')
            ->orwhere('p.date=:date')
            ->andwhere('p.disponibilite=:disponibilite')
            ->andwhere('p.statut =:statut')
            ->setParameters(['user'=> $user,'disponibilite'=>0,'statut'=>'non valide','date'=> $date->format('Y-m-d')])
            ->orderBy('p.id', 'ASC');
        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }

    

}
