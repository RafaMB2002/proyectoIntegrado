<?php

namespace App\Controller;

use App\Repository\BebidaRepository;
use App\Repository\PlatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartaController extends AbstractController
{
    #[Route('/carta', name: 'app_carta')]
    public function index(PlatoRepository $platoRepository, BebidaRepository $bebidaRepository): Response
    {

        $platos = $platoRepository->findAll();
        $bebidas = $bebidaRepository->findAll();

        return $this->render('carta/index.html.twig', [
            'controller_name' => 'CartaController',
            'platos' => $platos,
            'bebidas' => $bebidas
        ]);
    }
}
