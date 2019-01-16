<?php

namespace App\Repository;

use App\Entity\ServerKeys;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServerKeys|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServerKeys|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServerKeys[]    findAll()
 * @method ServerKeys[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerKeysRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServerKeys::class);
    }

    public function getKeyObject($id)
    {
        $arr = $this->createQueryBuilder('key')
            ->andWhere('key.serverId = :sId')
            ->setParameter('sId', $id)
            ->getQuery()
            ->getResult();
        return count($arr) > 0 ? $arr[0] : null;
    }
    // /**
    //  * @return ServerKeys[] Returns an array of ServerKeys objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
     */

    /*
    public function findOneBySomeField($value): ?ServerKeys
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
     */
}
