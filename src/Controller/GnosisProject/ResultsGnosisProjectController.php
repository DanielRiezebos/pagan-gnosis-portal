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
        $gnosisProject = $gnosisProjectRepository->find($id);

        /** @var Collection gnosisEntries */
        $gnosisEntries = $gnosisProject->getGnosisEntries();

        $gnosisStory = '';
        foreach($gnosisEntries as $gnosisEntry) {
            $gnosis = $gnosisEntry->getGnosis();
            $gnosisStory = $gnosisStory . $gnosis;            
        }

        return $this->render('gnosis-project/results.html.twig', [
            'gnosisProject' => $gnosisProject,
            'projectEntries' => $gnosisProject->getGnosisEntries(),
            'wordMapData' => array_count_values(str_word_count($gnosisStory, 1))
        ]);
    }
}
