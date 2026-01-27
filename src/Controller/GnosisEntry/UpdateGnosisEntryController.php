<?php

namespace App\Controller\GnosisEntry;

use App\Entity\GnosisEntry;
use App\Repository\GnosisEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class UpdateGnosisEntryController extends AbstractController
{
    #[Route('/update/gnosis/entry/{id}', name: 'app_update_gnosis_entry')]
    public function index(Request $request, GnosisEntryRepository $gnosisEntryRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true); 
        if (!array_key_exists('content', $requestData) || !array_key_exists('gnosis_id', $requestData)) {
            return new JsonResponse(['message' => 'This request does not match the requirements.'], 400);   
        }

        // I cast this to an object because I like casting things. 🧙🏻‍♂️
        $requestData = (object)$requestData;

        $gnosisEntryToUpdate = $gnosisEntryRepository->find($requestData->gnosis_id);
        $gnosisEntryToUpdate->setGnosis($requestData->content);

        $entityManager->persist($gnosisEntryToUpdate);
        $entityManager->flush();

        return new JsonResponse(['message' => 'GnosisEntry successfully updated!', 200]);
    }
}
