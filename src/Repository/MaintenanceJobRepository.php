<?php

namespace App\Repository;

use App\Entity\MaintenanceJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MaintenanceJob>
 *
 * @method MaintenanceJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaintenanceJob|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaintenanceJob[]    findAll()
 * @method MaintenanceJob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaintenanceJobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaintenanceJob::class);
    }

    //    /**
    //     * @return MaintenanceJob[] Returns an array of MaintenanceJob objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MaintenanceJob
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findGenericMaintenanceJobs(): array
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.generic = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult();

        return $qb;
    }
}
