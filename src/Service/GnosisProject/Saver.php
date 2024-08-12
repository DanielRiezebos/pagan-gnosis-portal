<?php

namespace App\Service\GnosisProject;

use App\Entity\GnosisProject;
use Doctrine\ORM\EntityManagerInterface;

class Saver
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(GnosisProject $gnosisProject) : bool
    {
        $this->entityManager->persist($gnosisProject);
        $this->entityManager->flush();

        return true;
    }
}