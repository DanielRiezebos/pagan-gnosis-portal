<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StartController extends AbstractController
{
    #[Route('/', name: 'start')]
    public function home(): Response
    {
        return $this->render("index.html.twig");
    }
}