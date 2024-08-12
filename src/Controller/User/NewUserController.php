<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class NewUserController extends AbstractController
{
    #[Route('/new/user', name: 'app_create_user')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $newUser = new User();
        $form = $this->createForm(UserType::class, $newUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (($form['Password']->getData() !== $form['ConfirmPassword']->getData())) {
                # TODO: Make error message here
                $this->redirect('app_create_user');
            }

            $newUser = $form->getData();
            $newUser->setPassword($passwordHasher->hashPassword($newUser, $newUser->getPassword()));

            $entityManager->persist($newUser);
            $entityManager->flush();

            return $this->redirectToRoute('app_users');
        }

        return $this->render('users/user.html.twig', [
            'form' => $form,
        ]);
    }
}
