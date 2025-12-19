<?php

namespace App\Controller;

use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StartController extends AbstractController
{
    #[Route('/', name: 'start')]
    public function home(SettingsRepository $settingsRepository): Response
    {
        return $this->render('index.html.twig', [
            'introText' => $settingsRepository->findOneBy(['SettingKey' => 'intro_text'])?->getSettingValue() ?? null,
        ]);
    }
}