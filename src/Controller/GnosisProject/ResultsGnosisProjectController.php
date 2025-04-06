<?php

namespace App\Controller\GnosisProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\GnosisProject;
use App\Repository\GnosisProjectRepository;

class ResultsGnosisProjectController extends AbstractController
{
    private $commonWords = [
        'a',
        'i',
        'the',
        'to',
        'that',
        'my',
        'and',
        'in',
        'also',
        'only',
        'for',
        'me',
        'is',
        'to',
        'been',
        'felt',
        'but',
        'or'
    ];

    #[Route('/results/gnosis/project/{id}', name: 'app_results_gnosis_project')]
    public function result(int $id, GnosisProjectRepository $gnosisProjectRepository): Response
    {
        /** @var GnosisProject gnosisProject */
        $gnosisProject = $gnosisProjectRepository->find($id);

        /** @var Collection gnosisEntries */
        $gnosisEntries = $gnosisProject->getGnosisEntries();

        $gnosisStory = '';
        foreach($gnosisEntries as $gnosisEntry) {
            $gnosis = $this->removeCommonWords($gnosisEntry->getGnosis());
            $gnosisStory = $gnosisStory . $gnosis;            
        }

        $resultComments = [];
        foreach($gnosisProject->getResultComments() as $comment) {
            $resultComments[] = [
                'id'      => $comment->getId(),
                'user'    => $comment->getUser()->getUsername(),
                'content' => $comment->getContent()
            ];
        }

        return $this->render('gnosis-project/results.html.twig', [
            'gnosisProject' => $gnosisProject,
            'projectEntries' => $gnosisProject->getGnosisEntries(),
            'resultComments' => array_reverse($resultComments), // TODO: Maybe make this using the repo for performance thingies
            'wordMapData' => array_count_values(str_word_count($gnosisStory, 1))
        ]);
    }

    private function removeCommonWords(string $gnosis) : string {
        $filteredGnosisAsArray = [];

        $unfilteredGnosis = explode(' ', $gnosis);        
        foreach ($unfilteredGnosis as $gnosisWord) {            
            if (!in_array(strtolower($gnosisWord), $this->commonWords)) {
                $filteredGnosisAsArray[] = $gnosisWord;
            }
        }

        return implode(' ', $filteredGnosisAsArray);
    }
}
