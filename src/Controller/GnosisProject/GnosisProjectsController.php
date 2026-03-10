<?php

declare(strict_types=1);

namespace App\Controller\GnosisProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GnosisProjectRepository;
use App\Repository\TagRepository;

class GnosisProjectsController extends AbstractController
{
    #[Route('/gnosis-projects', name:'gnosis-projects')]
    public function list(GnosisProjectRepository $gnosisProjectRepository, TagRepository $tagRepository, Request $request): Response
    {
        if (!empty($request->query->all('tags'))) {
            var_dump($request->query->all('tags'));
        }

        return $this->render(
            view: "gnosis-project/index.html.twig", 
            parameters: [
                'gnosis_projects' => array_reverse($gnosisProjectRepository->findAll()),
                'tags' => $tagRepository->findAll()
            ]
        );
    }
}