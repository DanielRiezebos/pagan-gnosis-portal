<?php

namespace App\Controller\GnosisProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\GnosisProject;
use App\Entity\ResultComment;
use App\Repository\GnosisProjectRepository;
use App\Repository\ResultCommentRepository;

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

    private $processedCommentIds = [];

    #[Route('/results/gnosis/project/{id}', name: 'app_results_gnosis_project')]
    public function result(int $id, GnosisProjectRepository $gnosisProjectRepository, ResultCommentRepository $resultCommentRepository): Response
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

        $displayComments = [];
        foreach($gnosisProject->getResultComments() as $comment) {
            if (in_array($comment->getId(), $this->processedCommentIds)) {
                continue;
            }

            $displayComments[] = [
                'id'      => $comment->getId(),
                'user'    => $comment->getUser()->getUsername(),
                'content' => $comment->getContent(),
                'children' => $this->getChildrenIfItHasAnyFrom($resultCommentRepository, $comment)
            ];

            $this->processedCommentIds[] = $comment->getId();
        }

        return $this->render('gnosis-project/results.html.twig', [
            'gnosisProject' => $gnosisProject,
            'projectEntries' => $gnosisProject->getGnosisEntries(),
            'resultComments' => array_reverse($displayComments), // TODO: Maybe make this using the repo for performance thingies
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

    private function getChildrenIfItHasAnyFrom(ResultCommentRepository $resultCommentRepository, ResultComment $comment): array
    {
        $children = [];
        foreach ($resultCommentRepository->getAllChildrenFrom($comment) as $childComment) {
            $children[] = [
                'id'      => $childComment->getId(),
                'user'    => $childComment->getUser()->getUsername(),
                'content' => $childComment->getContent(),
                'children' => $this->getChildrenIfItHasAnyFrom($resultCommentRepository, $childComment)
            ];
            $this->processedCommentIds[] = $childComment->getId();
        }

        return $children;
    }
}
