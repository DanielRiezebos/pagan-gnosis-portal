<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Role>
 */
class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * @return Role Returns the role based on title
     */
    public function getByTitle($title): Role
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Title = :val')
            ->setParameter('val', $title)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getSingleResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Role
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
