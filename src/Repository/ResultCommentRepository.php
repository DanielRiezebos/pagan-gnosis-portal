<?php

namespace App\Repository;

use App\Entity\GnosisProject;
use App\Entity\ResultComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;

/**
 * @extends ServiceEntityRepository<ResultComment>
 */
class ResultCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultComment::class);
    }

    public function getAllChildrenFrom(ResultComment $parentComment)
    {
        return $this->createQueryBuilder('rc')
                    ->andWhere('rc.ParentComment = :val')
                    ->setParameter('val', $parentComment->getId())
                    ->getQuery()
                    ->getResult();
    }

    public function countAllResultCommentsFrom(GnosisProject $gnosisProject) : int
    {
        return $this->createQueryBuilder('rc')
                    ->select('COUNT(rc.id)')
                    ->where('rc.GnosisProject = :val')
                    ->setParameter('val', $gnosisProject->getId())
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    //    /**
    //     * @return ResultComment[] Returns an array of ResultComment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ResultComment
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
