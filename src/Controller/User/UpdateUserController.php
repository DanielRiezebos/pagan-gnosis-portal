<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class UpdateUserController extends AbstractController
{
    #[Route('/update/user/{id}', name: 'app_update_user')]
    public function update(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, int $id): Response
    {
        /** @var User user */
        $user = $userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->redirectToRoute('app_users');
        }

        /** @var FormInterface form */
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users');
        }

        return $this->render('users/user.html.twig', [
            'form' => $form,
        ]);
    }
}
