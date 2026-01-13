<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Tarifs;
use App\Form\TarifsType;
use App\Repository\MessageRepository;
use App\Repository\TarifsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard')]
    public function dashboard(UserRepository $userRepository, MessageRepository $messageRepository): Response
    {
        $lastUsers = $userRepository->findLast(4);
        $lastMessages = $messageRepository->findLast(4);

        return $this->render('admin/dashboard/dashboard.html.twig', [
            'lastUser' => $lastUsers,
            'lastMessage' => $lastMessages,
        ]);
    }
}
