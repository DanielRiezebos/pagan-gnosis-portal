<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewGnosisProjectController extends AbstractController
{
    #[Route('/new/gnosis/project', name: 'app_new_gnosis_project')]
    public function index(): Response
    {
        return $this->render('gnosis-project/create.html.twig', [
            'controller_name' => 'NewGnosisProjectController',
        ]);
    }
}
