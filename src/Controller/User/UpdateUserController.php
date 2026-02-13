<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Service\User\Saver;
use App\Repository\UserRepository;
use App\Service\MailingService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UpdateUserController extends AbstractController
{
    #[Route('/update/user/{id}', name: 'app_update_user')]
    public function update(
        Request $request,
        Saver $saver,
        UserRepository $userRepository,
        MailingService $mailingService,
        int $id
    ): Response {
        /** @var User user */
        $user = $userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->redirectToRoute('app_users');
        }

        /** @var FormInterface form */
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $updatedUser = $form->getData();

            if (!$saver->save($updatedUser, $form->get('password')->getData())) {
                # TODO: Make error message here
                return $this->redirectToRoute('app_uapp_update_usersers');
            }

            // This indicates that the User has been banned.
            // TODO: Controllers ideally should not handle this kind of business logic - I should consider moving it elsewhere 
            if ($updatedUser->getStrikes() >= User::MAX_STRIKES) {
                $mailingService->sendUserBannedEmail($updatedUser);
            }

            return $this->redirectToRoute('app_users');
        }

        return $this->render('users/user.html.twig', [
            'form' => $form,
        ]);
    }
}
