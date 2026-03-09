<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class TagController extends AbstractController
{
    #[Route('/tags', name: 'app_tag')]
    public function index(TagRepository $tagRepository): Response
    {
        dd($tagRepository->findAll());
        die;
        return $this->render('tag/index.html.twig', [
            'tags' => $tagRepository->findAllImploded(),
        ]);
    }

    #[Route('/tags/save', name: 'save_tags')]
    public function save(Request $request)
    {
        dd('This is the save function speaking!', $request);
    }

    #[Route('/tags/delete/{tag_id}', name: 'delete_tag')]
    public function delete(Request $request)
    {
        dd('This is the delete function speaking!', $request);
    }
}
