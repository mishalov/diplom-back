<?php

namespace App\Repository;

use App\Entity\Privileges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Privileges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Privileges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Privileges[]    findAll()
 * @method Privileges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivilegesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Privileges::class);
    }

    // /**
    //  * @return Privileges[] Returns an array of Privileges objects
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
    public function findOneBySomeField($value): ?Privileges
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
