<?php

namespace App\Repository;

use App\Entity\PotionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PotionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PotionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PotionType[]    findAll()
 * @method PotionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PotionTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PotionType::class);
    }

    // /**
    //  * @return PotionType[] Returns an array of PotionType objects
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
    public function findOneBySomeField($value): ?PotionType
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
