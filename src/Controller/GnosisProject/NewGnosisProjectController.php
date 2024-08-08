<?php

namespace App\Controller\GnosisProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\GnosisProject;
use App\Form\GnosisProjectType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class NewGnosisProjectController extends AbstractController
{
    #[Route('/new/gnosis/project', name: 'app_new_gnosis_project')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newGnosisProject = new GnosisProject();
        $form = $this->createForm(GnosisProjectType::class, $newGnosisProject);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newGnosisProject = $form->getData();

            $entityManager->persist($newGnosisProject);
            $entityManager->flush();

            return $this->redirectToRoute('gnosis-projects');
        }

        return $this->render('gnosis-project/gnosis-project.html.twig', [
            'form' => $form,
        ]);
    }
}
