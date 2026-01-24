<?php

namespace App\Controller\GnosisEntry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UpdateGnosisEntryController extends AbstractController
{
    #[Route('/update/gnosis/entry/{id}', name: 'app_update_gnosis_entry')]
    public function index(): Response
    {
        dd('Hello world!');
    }
}
