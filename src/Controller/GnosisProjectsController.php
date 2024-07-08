<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GnosisProjectsController extends AbstractController
{
    #[Route('/gnosis-projects', name:'gnosis-projects')]
    public function list(): Response
    {
        return new Response('This is where the Gnosis Projects will be displayed');
    }
}