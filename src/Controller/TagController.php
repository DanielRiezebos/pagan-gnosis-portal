<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class TagController extends AbstractController
{
    #[Route('/tags', name: 'app_tag')]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->render('tag/index.html.twig', [
            'tags' => $tagRepository->findAll(),
        ]);
    }

    #[Route('/save/tag', name: 'save_tag')]
    public function save(Request $request, EntityManagerInterface $entityManager)
    {
        $requestContent = json_decode($request->getContent(), true);
        if (!array_key_exists('tagText', $requestContent)) {
            return new JsonResponse(['error' => 'No tag text was brought forth in the HTTP request.'], 400);
        }

        if (empty($requestContent['tagText'])) {
            return new JsonResponse(['error' => 'Tag labels cannot be empty'], 400);
        }

        $newTag = new Tag();
        $newTag->setLabel($requestContent['tagText']);

        $entityManager->persist($newTag);
        $entityManager->flush();

        return new JsonResponse(['message' => 'New tag was added succesfully!'], 200);
    }

    #[Route('/delete/tag/{tag_id}', name: 'delete_tag')]
    public function delete(Request $request, EntityManagerInterface $entityManager)
    {
        $requestContent = json_decode($request->getContent(), true);
        if (!array_key_exists('tagId', $requestContent)) {
            return new JsonResponse(['error' => 'No tag ID has been found.'], 400);
        }

        $tagToDelete = $entityManager->getRepository(Tag::class)->find($requestContent['tagId']);
        if (is_null($tagToDelete)) {
            return new JsonResponse(['error' => 'This tag does not exit in the database'], 404);
        }

        $entityManager->remove($tagToDelete);
        $entityManager->flush();

        return new JsonResponse(['message' => 'The tag was deleted succesfully.'], 200);
    }
}
