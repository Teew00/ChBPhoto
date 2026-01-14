<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Form\ConversationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if(!$user){
            $this->addFlash('info', 'Connecter vous pour pouvoir acceder à la messagerie');
            return $this->redirectToRoute('app_register');
        }

        $conversation = new Conversation();
        $conversation->setIdUser($user);

        $form = $this->createForm(ConversationType::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($conversation);
            $entityManager->flush();

            $message = new Message();
            $message->setIdConversation($conversation);
            $message->setIdUser($user);
            $message->setContenu($form->get('firstMessage')->getData());

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_conversation_show', ['id'=>$conversation->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->render('home/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
