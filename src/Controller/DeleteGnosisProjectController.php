<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\GnosisProject;

class DeleteGnosisProjectController extends AbstractController
{
    #[Route('/delete/gnosis/project/{id}', name: 'app_delete_gnosis_project')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $gnosisProject = $entityManager->getRepository(GnosisProject::class)->find($id);
        if (!$gnosisProject) {
            return $this->redirectToRoute('gnosis-projects');
        }

        $entityManager->remove($gnosisProject);
        $entityManager->flush();

        return $this->redirectToRoute('gnosis-projects');
    }
}
