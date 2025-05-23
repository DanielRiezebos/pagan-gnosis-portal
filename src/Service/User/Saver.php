<?php

namespace App\Service\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Saver
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function save(User $user, ?string $password) : bool
    {
        if (!empty($password)) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        }        

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }
}