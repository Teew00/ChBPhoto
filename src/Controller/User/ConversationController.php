<?php

namespace App\Controller\User;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile/conversation')]
final class ConversationController extends AbstractController
{
    #[Route('/{id}', name: 'app_conversation_show', methods: ['GET', 'POST'])]
    public function show(Conversation $conversation, Request $request, EntityManagerInterface $entityManager, int  $id): Response
    {
        $user = $this->getUser();

        if ($user !== $conversation->getIdUser() && !in_array('ROLE_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('Accès interdit.');
        }

        $message = new Message();
        $message->setIdConversation($conversation);
        $message->setIdUser($user);

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_conversation_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }


        return $this->render('conversation/show.html.twig', [
            'conversation' => $conversation,
            'form' => $form,
        ]);
    }
}
