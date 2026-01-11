<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Form\EditUserType;
use App\Form\UserType;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile')]
    public function index(MessageRepository $messageRepository, ConversationRepository $conversationRepository): Response
    {
        $user = $this->getUser();

        if ($user->getRoles() == ['ROLE_ADMIN']) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $conversation = $conversationRepository->findBy(['idUser' => $user]);

        $messages = null;

        if ($conversation) {
            $messages = $messageRepository->findBy(
                ['idConversation' => $conversation],
                ['createdAt' => 'DESC'],
                2
            );
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'messages' => $messages,
        ]);
    }

    #[Route('/modifier/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);

    }
}
