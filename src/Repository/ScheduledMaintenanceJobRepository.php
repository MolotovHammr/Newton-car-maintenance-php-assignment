<?php

namespace App\Repository;

use App\Entity\ScheduledMaintenanceJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ScheduledMaintenanceJob>
 *
 * @method ScheduledMaintenanceJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduledMaintenanceJob|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduledMaintenanceJob[]    findAll()
 * @method ScheduledMaintenanceJob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduledMaintenanceJobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScheduledMaintenanceJob::class);
    }

    //    /**
    //     * @return ScheduledMaintenanceJob[] Returns an array of ScheduledMaintenanceJob objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ScheduledMaintenanceJob
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
