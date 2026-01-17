<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profil')]
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
        $idConversation = null;

        if ($conversation) {
            $messages = $messageRepository->findBy(
                ['idConversation' => $conversation],
                ['createdAt' => 'DESC'],
                2
            );

            $temp = $messages[0];
            $messages[0] = $messages[1];
            $messages[1] = $temp;


            $idConversation = $conversation[0]->getId();
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'messages' => $messages,
            'idConversation' => $idConversation,
        ]);
    }

    #[Route('/modifier', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                     $request,
        EntityManagerInterface      $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('motDePasse')->getData();

            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setMotDePasse($hashedPassword);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');

            return $this->redirectToRoute('app_profile', [
                'id' => $user->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/modifier/motdepasse', name: 'app_user_edit_password', methods: ['GET', 'POST'])]
    public function changePassword(
        Request                     $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface      $em
    ): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();

            // Vérifier l'ancien mot de passe
            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Mot de passe actuel incorrect.');
                return $this->redirectToRoute('app_user_edit_password');
            }

            // Hasher le nouveau mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setMotDePasse($hashedPassword);

            $em->flush();

            $this->addFlash('success', 'Mot de passe modifié avec succès.');
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        return $this->render('profile/user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
