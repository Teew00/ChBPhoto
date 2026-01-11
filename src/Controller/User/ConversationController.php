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
        $message = new Message();
        $message->setIdConversation($conversation);
        $message->setIdUser($this->getUser());

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

//    #[Route('/new', name: 'app_conversation_new', methods: ['GET', 'POST'])]
//    public function new(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $conversation = new Conversation();
//        $form = $this->createForm(ConversationType::class, $conversation);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($conversation);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->render('conversation/new.html.twig', [
//            'conversation' => $conversation,
//            'form' => $form,
//        ]);
//    }

//    #[Route(name: 'app_conversation_index', methods: ['GET'])]
//    public function index(ConversationRepository $conversationRepository): Response
//    {
//        return $this->render('conversation/index.html.twig', [
//            'conversations' => $conversationRepository->findAll(),
//        ]);
//    }

//    #[Route('/{id}/edit', name: 'app_conversation_edit', methods: ['GET', 'POST'])]
//    public function edit(Request $request, Conversation $conversation, EntityManagerInterface $entityManager): Response
//    {
//        $form = $this->createForm(ConversationType::class, $conversation);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->flush();
//
//            return $this->redirectToRoute('app_conversation_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->render('conversation/edit.html.twig', [
//            'conversation' => $conversation,
//            'form' => $form,
//        ]);
//    }

//    #[Route('/{id}', name: 'app_conversation_delete', methods: ['POST'])]
//    public function delete(Request $request, Conversation $conversation, EntityManagerInterface $entityManager): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$conversation->getId(), $request->getPayload()->getString('_token'))) {
//            $entityManager->remove($conversation);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('app_conversation_index', [], Response::HTTP_SEE_OTHER);
//    }
}
