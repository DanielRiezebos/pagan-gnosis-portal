<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin-user',
    description: 'This command will be enable you to make an admin user. Perhaps this should not be here :p',
)]
class CreateAdminUserCommand extends Command
{
    protected static $defaultName = 'app:create-admin-user';
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    private RoleRepository $roleRepository;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, RoleRepository $roleRepository)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->roleRepository = $roleRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Creates an admin user with a hashed password.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // To do: Perhaps add a security question that the user need to answer correctly, based upon some Pagan lore?
        $firstAdmin = new User();
        $adminRole = $this->roleRepository->getByTitle('ROLE_ADMINISTRATOR');
        $firstAdmin->setUsername('FirstAdmin');
        $hashedPassword = $this->passwordHasher->hashPassword($firstAdmin, $_ENV['SUPER_ADMIN_PASSWD']);
        $firstAdmin->setPassword($hashedPassword);
        $firstAdmin->setRole($adminRole);

        $this->entityManager->persist($firstAdmin);
        $this->entityManager->flush();

        $output->writeln('Admin user created successfully!');

        return Command::SUCCESS;
    }
}
