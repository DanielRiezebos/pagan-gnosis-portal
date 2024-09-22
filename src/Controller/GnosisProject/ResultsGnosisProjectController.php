<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManager;
use App\Entity\GnosisProject;

class ResultsGnosisProjectController extends AbstractController
{
    #[Route('/results/gnosis/project/{id}', name: 'app_results_gnosis_project')]
    public function index(): Response
    {
        // TODO: Make a collection of all Gnosis Entries here and see if you can make some kind of word map here
        return $this->render('gnosis-project/results.html.twig', [
            'controller_name' => 'ResultsGnosisProjectController',
        ]);
    }
}
