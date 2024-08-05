<?php

declare(strict_types=1);

namespace App\Controller\GnosisProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\GnosisProjectRepository;

class GnosisProjectsController extends AbstractController
{
    #[Route('/gnosis-projects', name:'gnosis-projects')]
    public function list(GnosisProjectRepository $gnosisProjectRepository): Response
    {
        return $this->render("gnosis-project/index.html.twig", ['gnosis_projects' => $gnosisProjectRepository->findAll()]);
    }
}