<?php

namespace App\Controller\GnosisProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\GnosisProject;
use App\Repository\GnosisProjectRepository;

class ResultsGnosisProjectController extends AbstractController
{
    #[Route('/results/gnosis/project/{id}', name: 'app_results_gnosis_project')]
    public function result(int $id, GnosisProjectRepository $gnosisProjectRepository): Response
    {
        /** @var GnosisProject gnosisProject */
        $gnosisProject = $gnosisProjectRepository->findOneBy(['id' => $id]);

        dd($gnosisProject->getGnosisEntries());
        // TODO: Make a collection of all Gnosis Entries here and see if you can make some kind of word map here
        return $this->render('gnosis-project/results.html.twig', [
            'controller_name' => 'ResultsGnosisProjectController',
        ]);
    }
}
