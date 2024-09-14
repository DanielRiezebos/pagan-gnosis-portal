<?php

namespace App\Controller\GnosisEntry;

use App\Entity\GnosisProject;
use App\Entity\GnosisEntry;
use App\Form\GnosisEntryType;
use App\Service\GnosisEntry\Saver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

class CreateGnosisEntryController extends AbstractController
{
    #[Route('/create/gnosis/project/entry/{id}', name: 'app_create_gnosis_entry')]
    public function create(GnosisProject $gnosisProject, Saver $saver, Request $request): Response
    {
        $newGnosisProjectEntry = new GnosisEntry();
        $newGnosisProjectEntry->setGnosisprojectId($gnosisProject);
        $newGnosisProjectEntry->setUserId($this->getUser());
        $form = $this->createForm(GnosisEntryType::class, $newGnosisProjectEntry);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newGnosisProjectEntry = $form->getData();
            $newGnosisProjectEntry->setCreatedAt(now());

            $saver->save($newGnosisProjectEntry);

            return $this->redirectToRoute('gnosis-projects');
        }

        return $this->render('gnosis-entry/gnosis-entry.html.twig', [
           'form' => $form,
           'gnosisProject' => $gnosisProject,
        ]);
    }
}
