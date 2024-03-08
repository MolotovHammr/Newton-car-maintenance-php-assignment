<?php

namespace App\Repository;

use App\Entity\SparePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SparePart>
 *
 * @method SparePart|null find($id, $lockMode = null, $lockVersion = null)
 * @method SparePart|null findOneBy(array $criteria, array $orderBy = null)
 * @method SparePart[]    findAll()
 * @method SparePart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SparePartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SparePart::class);
    }

    //    /**
    //     * @return SparePart[] Returns an array of SparePart objects
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

    public function findByIds(array $ids): array
    {
        // Create a query builder
        $qb = $this->createQueryBuilder('s');

        // Add a WHERE clause to filter by IDs
        $qb->andWhere($qb->expr()->in('s.id', ':ids'))
           ->setParameter('ids', $ids);

        // Execute the query and return the result
        return $qb->getQuery()->getResult();
    }
}
