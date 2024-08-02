<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\GnosisProjectRepository;

class GnosisProjectsController extends AbstractController
{
    #[Route('/gnosis-projects', name:'gnosis-projects')]
    public function list(GnosisProjectRepository $gnosisProjectRepository): Response
    {
        $allGnosisProjects = $gnosisProjectRepository->findAll();

        return new Response($allGnosisProjects[0]->getTitle(). ' ' .$allGnosisProjects[0]->getDescription());
    }
}