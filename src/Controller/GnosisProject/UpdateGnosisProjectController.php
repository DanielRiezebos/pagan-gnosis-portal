<?php

namespace App\Controller\GnosisProject;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\GnosisProject;
use App\Form\GnosisProjectType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GnosisProjectRepository;

class UpdateGnosisProjectController extends AbstractController
{
    #[Route('/update/gnosis/project/{id}', name: 'app_update_gnosis_project')]
    public function update(Request $request, EntityManagerInterface $entityManager, GnosisProjectRepository $gnosisProjectRepository, int $id): Response
    {
        $gnosisProject = $gnosisProjectRepository->findOneBy(['id' => $id]);
        if (!$gnosisProject) {
            return $this->redirectToRoute('gnosis-projects');
        }

        $form = $this->createForm(GnosisProjectType::class, $gnosisProject);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gnosisProject = $form->getData();

            $entityManager->persist($gnosisProject);
            $entityManager->flush();

            return $this->redirectToRoute('gnosis-projects');
        }

        return $this->render('gnosis-project/gnosis-project.html.twig', [
            'form' => $form,
        ]);
    }
}
