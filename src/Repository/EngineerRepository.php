<?php

namespace App\Repository;

use App\Entity\Engineer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Engineer>
 *
 * @method Engineer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Engineer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Engineer[]    findAll()
 * @method Engineer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngineerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Engineer::class);
    }

    //    /**
    //     * @return Engineer[] Returns an array of Engineer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Engineer
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
