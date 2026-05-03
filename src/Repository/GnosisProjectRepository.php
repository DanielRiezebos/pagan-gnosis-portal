<?php

namespace App\Repository;

use App\Entity\GnosisProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GnosisProject>
 */
class GnosisProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GnosisProject::class);
    }

    /**
     * @param array $tags
     * @return array
     */
    public function findByTags(array $tags): array
    {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder
                ->innerJoin('p.tags', 't')
                ->where('t IN (:tags)')
                ->setParameter('tags', $tags)
                ->getQuery()
                ->getResult();
    }
}
