<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/conversations')]
class ConversationController extends AbstractController
{
    #[Route('/', name: 'app_admin_conversation_index', methods: ['GET'])]
    public function index(ConversationRepository $conversationRepository): Response
    {
        return $this->render('admin/conversation/index.html.twig', [
            'conversations' => $conversationRepository->findAll(),
        ]);
    }
}
