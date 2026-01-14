<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Tarifs;
use App\Form\TarifsType;
use App\Repository\TarifsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/tarifs')]
class TarifsController extends AbstractController
{
    #[Route('/', name: 'app_admin_tarifs')]
    public function tarifs(TarifsRepository $tarifsRepository): Response
    {
        $tarifs = $tarifsRepository->findAll();


        return $this->render('admin/tarifs/tarifs.html.twig', [
            'tarifs' => $tarifs,
        ]);
    }

    #[Route('/new', name: 'app_admin_tarifs_new')]
    public function tarifsNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarif = new Tarifs();
        $form = $this->createForm(TarifsType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tarif);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tarifs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tarifs/new.html.twig', [
            'tarif' => $tarif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tarifs_edit', methods: ['GET', 'POST'])]
    public function TarifsEdit(Request $request, Tarifs $tarif, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TarifsType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tarifs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tarifs/edit.html.twig', [
            'tarif' => $tarif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_tarifs_delete', methods: ['POST'])]
    public function tarifsDelete(Request $request, Tarifs $tarif, EntityManagerInterface $entityManager): Response
    {
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $tarif->getId(), $token)) {
            $entityManager->remove($tarif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_tarifs', [], Response::HTTP_SEE_OTHER);
    }
}
