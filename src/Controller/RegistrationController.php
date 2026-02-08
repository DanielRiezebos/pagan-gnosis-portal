<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\MailingService;
use App\Service\User\Saver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'get_registration', methods: ['GET'])]
    public function registerForm(): Response
    {
        return $this->render('registration/index.html.twig');
    }

    #[Route('/registration', name: 'post_registration', methods: ['POST'])]
    public function registerAction(
        Request $request,
        Saver $saver,
        EntityManagerInterface $entityManager,
        MailingService $mailer,
        UserRepository $userRepository
    ) {
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        $email = $request->request->get('_email');
        $repeatPassword = $request->request->get('_repeat-password');

        // Validate existence of variables
        if (!$username ||
            !$password ||
            !$email ||
            !$repeatPassword
        ) {
            $this->addFlash('error', 'Please fill in all fields.');
            return $this->redirectToRoute('get_registration');
        }

        if ($password !== $repeatPassword) {
            $this->addFlash('error', 'Passwords do not match');
            return $this->redirectToRoute('get_registration');
        }

        if ($userRepository->findOneBy(['email' => $email]) !== null) {
            $this->addFlash('error', 'A user with this email address already exists. Please log in with your email address.');
            return $this->redirectToRoute('get_registration');
        }
    

        $roleRepository = $entityManager->getRepository(Role::class);

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRole($roleRepository->findOneBy(['Title' => Role::RoleUser]));
        $user->setStrikes(0);
        if (!$saver->save($user, $password)) {
            $this->addFlash('error', 'Something went wrong while registering');
            return $this->redirectToRoute('get_registration');
        }

        // Send registration emails
        $mailer->sendRegistrationMailsTo($user);
        $mailer->sendRegistrationMailToAdmin($user);

        return $this->redirectToRoute('finished_registration');
    }

    #[Route('/registrationcomplete', name: 'finished_registration', methods: ['GET'])]
    public function finishRegistration()
    {
        return $this->render('registration/finished.html.twig');
    }
}
