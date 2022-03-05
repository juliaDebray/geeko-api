<?php

namespace App\Repository;

use App\Entity\Potion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Potion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Potion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Potion[]    findAll()
 * @method Potion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Potion::class);
    }

    // Retourne les potions selon le statut demandé
    public function findByStatus($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Potion
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
