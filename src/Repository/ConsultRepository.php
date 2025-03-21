<?php

namespace App\Repository;

use App\Entity\Consult;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consult>
 */
class ConsultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consult::class);
    }
    public function findConsultationsToday(User $veterinary)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.consultDate = :today')
            ->andWhere('c.veterinary = :vet')
            ->setParameter('today', new \DateTime('today'))
            ->setParameter('vet', $veterinary)
            ->getQuery()
            ->getResult();
    }
    public function findConsultationsBetweenDates(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.consultDate BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }
    

    
//    /**
//     * @return Consult[] Returns an array of Consult objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Consult
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
