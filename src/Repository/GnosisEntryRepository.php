<?php

namespace App\Repository;

use App\Entity\GnosisEntry;
use App\Entity\User;
use App\Entity\GnosisProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GnosisEntry>
 */
class GnosisEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GnosisEntry::class);
    }

    /**
     * @return GnosisEntry[] Returns an array of GnosisEntry object specific to a given User and GnosisProject
     */
    public function findByUserAndProject(User $user, GnosisProject $gnosisProject): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.user = :user')
            ->andWhere('e.gnosisproject = :gnosisproject')
            ->setParameter('user', $user->getId())
            ->setParameter('gnosisproject', $gnosisProject->getId())
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return GnosisEntry[] Returns an array of GnosisEntry objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GnosisEntry
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
