<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Galerie;
use App\Entity\Photo;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/photo')]
class PhotoController extends AbstractController
{
    #[Route('/{idGalerie}/new', name: 'app_admin_photo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $idGalerie): Response
    {
        $galerie = $entityManager->getRepository(Galerie::class)->find($idGalerie);
        if (!$galerie) {
            throw $this->createNotFoundException("La galerie n'existe pas.");
        }

        $photo = new Photo();
        $photo->setIdGalerie($galerie);

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_galerie_show', ['id' => $idGalerie], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    #[Route('/{idGalerie}/{id}/edit', name: 'app_admin_photo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Photo $photo, EntityManagerInterface $entityManager, $idGalerie): Response
    {
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_galerie_show', ['id' => $idGalerie], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    #[Route('/{idGalerie}/{id}/del', name: 'app_admin_photo_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Photo $photo, EntityManagerInterface $entityManager, $idGalerie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_galerie_show', ['id' => $idGalerie], Response::HTTP_SEE_OTHER);
    }
}
