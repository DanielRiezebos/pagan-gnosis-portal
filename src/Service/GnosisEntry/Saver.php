<?php

namespace App\Service\GnosisEntry;

use App\Entity\GnosisEntry;
use Doctrine\ORM\EntityManagerInterface;

class Saver
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(GnosisEntry $gnosisEntry) : bool
    {
        $this->entityManager->persist($gnosisEntry);
        $this->entityManager->flush();

        return true;
    }
}