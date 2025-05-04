<?php

namespace App\Controller;

use App\Entity\GnosisProject;
use App\Entity\ResultComment;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

class ResultCommentAjaxController extends AbstractController
{
    #[Route('/result/comment', name: 'result_comment_ajax', methods: ['POST'])]
    public function postComment(Request $request, EntityManagerInterface $entityManager)
    {
        $commentData = json_decode($request->getContent(), true);        
        $commentDataContent = $commentData['content'];

        if (!isset($commentDataContent) || empty($commentDataContent)) {
            return new JsonResponse(['error' => 'There was no comment content found.'], 400);
        }

        $gnosisProject = $entityManager->getRepository(GnosisProject::class)->find($commentData['gnosisProjectId']);
        $user = $entityManager->getRepository(User::class)->find($commentData['userId']);

        $resultComment = new ResultComment();
        $resultComment->setContent($commentDataContent);
        $resultComment->setUser($user);
        $resultComment->setGnosisProject($gnosisProject);
        $resultComment->setCreatedAt(now());

        // If a parent comment is provided, set it
        if (!empty($commentData['parentId'])) {
            $parentComment = $entityManager->getRepository(ResultComment::class)->find($commentData['parentId']);
            if ($parentComment) {
                $resultComment->setParent($parentComment);
            }
        }        

        $entityManager->persist($resultComment);
        $gnosisProject->addResultComment($resultComment);
        $user->addResultComment($resultComment);

        $entityManager->flush();

        return new JsonResponse(['message' => 'Comment added!'], 200);
    }

    #[Route('/result/comment/remove/{commentId}', name: 'result_comment_ajax_remove', methods: ['POST'])]
    public function removeComment(Request $request, EntityManagerInterface $entityManager)
    {
        $requestContent = json_decode($request->getContent(), true);
        $user = $entityManager->getRepository(User::class)->find($requestContent['userId']);
        $resultComment = $entityManager->getRepository(ResultComment::class)->find($requestContent['commentId']);

        // If $user is not an administrator, nor author of the resultcomment, then return with an error.
        if ($user->getRole()->getTitle() !== 'ROLE_ADMINISTRATOR') {
            if ($resultComment->getUser()->getId() !== $user->getId()) {
                return new JsonResponse(['error' => 'User is neither an Adminstrator nor Result Comment author'], 403);
            }
        }

        $resultComment->setDeletedAt(new DateTimeImmutable());
        $entityManager->persist($resultComment);
        $entityManager->flush();

        return new JsonResponse('success');
    }
}
