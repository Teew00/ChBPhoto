<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function dashboard(UserRepository $userRepository, MessageRepository $messageRepository): Response
    {
        $user = $this->getUser();

        if ($user->getRoles() !== ['ROLE_ADMIN']) {
            return $this->redirectToRoute('app_home');
        }

        $lastUsers = $userRepository->findLast(4);
        $lastMessages = $messageRepository->findLast(4);

        return $this->render('admin/dashboard.html.twig', [
            'lastUser' => $lastUsers,
            'lastMessage' => $lastMessages,
        ]);
    }
}
