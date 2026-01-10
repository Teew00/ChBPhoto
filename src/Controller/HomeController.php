<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Repository\GalerieRepository;
use App\Repository\TarifsRepository;
use App\Service\TarifProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/sport', name: 'app_home_sport')]
    public function sport(GalerieRepository $galerieRepository): Response
    {
        $galeries = $galerieRepository->find(1);

        return $this->render('home/sport.html.twig', [
            'galerie' => $galeries,
        ]);
    }

    #[Route('/evenement', name: 'app_home_event')]
    public function event(GalerieRepository $galerieRepository): Response
    {
        $galeries = $galerieRepository->find(2);

        return $this->render('home/event.html.twig', [
            'galerie' => $galeries,
        ]);
    }

    #[Route('/objet', name: 'app_home_objet')]
    public function objet(GalerieRepository $galerieRepository): Response
    {
        $galeries = $galerieRepository->find(3);

        return $this->render('home/objet.html.twig', [
            'galerie' => $galeries,
        ]);
    }

    #[Route('/apropos', name: 'app_home_apropos')]
    public function apropos(): Response
    {
        return $this->render('home/apropos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/tarifs', name: 'app_home_tarifs')]
    public function tarifs(TarifsRepository $tarifsRepository): Response
    {
        $tarifs = $tarifsRepository->findAll();


        return $this->render('home/tarifs.html.twig', [
            'tarifs' => $tarifs,
        ]);
    }
}
