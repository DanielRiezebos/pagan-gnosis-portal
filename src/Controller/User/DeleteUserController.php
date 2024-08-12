<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class DeleteUserController extends AbstractController
{
    #[Route('/delete/user/{id}', name: 'app_delete_user')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return $this->redirectToRoute('app_users');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_users');
    }
}
