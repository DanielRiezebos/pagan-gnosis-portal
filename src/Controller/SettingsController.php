<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Repository\SettingsRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(SettingsRepository $settingsRepository, TagRepository $tagRepository): Response
    {
        return $this->render('settings/index.html.twig', [
            'settings' => $settingsRepository->findAll()
        ]);
    }

    #[Route('/settings/save', name:'app_settings_save')]
    public function saveSettings(EntityManagerInterface $entityManager, SettingsRepository $settingsRepository, Request $request)
    {
        // First let us save the standard settings
        foreach (json_decode($request->getContent(), true) as $settingsItem) {
            $theSetting = $settingsRepository->findOneBy(['SettingKey' => $settingsItem['key']]) ?? new Setting();
            $theSetting->setSettingKey($settingsItem['key']);
            $theSetting->setSettingValue($settingsItem['value']);

            $entityManager->persist($theSetting);
            $entityManager->flush();
        }

        return new JsonResponse(['message' => 'Settings saved!'], 200);
    }
}
