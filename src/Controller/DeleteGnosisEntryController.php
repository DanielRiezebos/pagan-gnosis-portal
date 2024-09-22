<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\GnosisEntry;

class DeleteGnosisEntryController extends AbstractController
{
    // TODO: Add some security to such a delete route - do I know for certain that I am the one allowed to delete this Gnosis Entry?
    #[Route('/delete/gnosis/project/entry/{id}', name: 'app_delete_gnosis_entry')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $gnosisEntry = $entityManager->getRepository(GnosisEntry::class)->find($id);
        $gnosisProjectId = $gnosisEntry->getGnosisprojectId();
        if (!$gnosisEntry) {
            return $this->redirectToRoute('gnosis-projects');
        };

        $entityManager->remove($gnosisEntry);
        $entityManager->flush();

        return $this->redirectToRoute('app_create_gnosis_entry', ['id' => $gnosisProjectId->getId()]);
    }
}
