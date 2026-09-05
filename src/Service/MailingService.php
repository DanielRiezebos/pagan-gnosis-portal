<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\SettingsRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;

class MailingService
{
    private MailerInterface $mailer;
    private SettingsRepository $settingsRepository;

    public function __construct(
        MailerInterface $mailer,
        SettingsRepository $settingsRepository
    ) {
        $this->mailer = $mailer;
        $this->settingsRepository = $settingsRepository;
    }

    public function getAdminEmail() : ?string
    {
        return $this->settingsRepository->findOneBy(['SettingKey' => 'admin_email'])?->getSettingValue() ?? $_ENV['SUPER_ADMIN_EMAIL'];
    }

    public function sendRegistrationMailsTo(User $newUser) : Response
    {
        $adminEmail = $this->getAdminEmail();

        // $this->mailer->send((new TemplatedEmail())
        //     ->from($adminEmail)
        //     ->to(new Address($newUser->getEmail()))
        //     ->subject('Welcome to the Pagan Gnosis Portal!')
        //     ->htmlTemplate('emails/registration.html.twig')
        //     ->context([
        //         'username' => $newUser->getUsername(),
        //         'adminEmailAddress' => $adminEmail
        //     ]));

        $email = (new Email())
            ->from($adminEmail)
            ->to(new Address($newUser->getEmail()))
            ->subject('Test e-mail via Brevo')
            ->text('Dit is een testbericht verstuurd met Symfony Mailer en Brevo!')
            ->html('<p>Dit is een <strong>testbericht</strong> verstuurd met Symfony Mailer en Brevo!</p>');

        $this->mailer->send($email);

        return new Response('E-mail succesvol verzonden!');
    }

    public function sendRegistrationMailToAdmin(User $newUser) : void
    {
        $this->mailer->send((new TemplatedEmail())
            ->from($this->getAdminEmail())
            ->to(new Address($this->getAdminEmail()))
            ->subject('A new user has registered to the portal')
            ->htmlTemplate('emails/registration_admin.html.twig')
            ->context([
                'username' => $newUser->getUsername(),
                'emailadress' => $newUser->getEmail()
            ]));
    }

    public function sendUserBannedEmail(User $bannedUser)
    {
        $adminEmail = $this->getAdminEmail();

        $this->mailer->send((new TemplatedEmail())
            ->from($adminEmail)
            ->to(new Address($bannedUser->getEmail()))
            ->subject('You have been banned from the Pagan Gnosis Portal')
            ->htmlTemplate('emails/banned.html.twig')
            ->context([
                'username' => $bannedUser->getUsername(),
                'adminEmailAddress' => $adminEmail
            ]));
    }
}