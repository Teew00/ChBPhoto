<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\GalerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/galerie')]
class GalerieController extends AbstractController
{
    #[Route('/', name: 'app_admin_galerie')]
    public function index(GalerieRepository $galerieRepository): Response
    {
        return $this->render('admin/galerie/index.html.twig', [
            'galeries' => $galerieRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_galerie_show', methods: ['GET', 'POST'])]
    public function show(GalerieRepository $galerieRepository, $id): Response
    {
        $galeries = $galerieRepository->find($id);

        return $this->render('admin/galerie/show.html.twig', [
            'galerie' => $galeries,
        ]);
    }
}
