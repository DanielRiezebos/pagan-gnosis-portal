<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use App\Service\User\Saver;

class NewUserController extends AbstractController
{
    #[Route('/new/user', name: 'app_create_user')]
    public function new(Request $request, Saver $saver): Response
    {
        $newUser = new User();
        $form = $this->createForm(UserType::class, $newUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();

            if (!$saver->save($newUser)) {
                # TODO: Make error message here
                $this->redirect('app_create_user');
            }

            return $this->redirectToRoute('app_users');
        }

        return $this->render('users/user.html.twig', [
            'form' => $form,
        ]);
    }
}
