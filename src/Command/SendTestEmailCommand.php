<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\MailingService;

#[AsCommand(
    name: 'app:send-test-email',
    description: 'Use this command to test the email functionality.',
)]
class SendTestEmailCommand extends Command
{
    public function __construct(
        private MailerInterface $mailer,
        private MailingService $mailingService
    ) {
        $this->mailer = $mailer;
        $this->mailingService = $mailingService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('recipient', InputArgument::OPTIONAL, 'Where should the testmail be send to?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $recipient = $input->getArgument('recipient');
        
        if (!$recipient) {
            $io->error('No recipient to send email to, add argument like this: recipient="some@emailadress.nl"');
            return Command::FAILURE;
        }

        $adminEmail = $this->mailingService->getAdminEmail();

        $this->mailer->send((new TemplatedEmail())
            ->from($adminEmail)
            ->to(new Address($recipient))
            ->subject('You received test-mail from the Pagan Gnosis Portal!')
            ->htmlTemplate('emails/test.html.twig')
            ->context([
                'recipient' => $recipient,
                'adminEmailAddress' => $adminEmail
            ]));

        $io->success('Email code has succesfully been run, check your mailbox for the results!');
        return Command::SUCCESS;
    }
}
