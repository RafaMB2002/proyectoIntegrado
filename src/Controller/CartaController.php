<?php

namespace App\Controller;

use App\Repository\BebidaRepository;
use App\Repository\PlatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controlador para la gestion de la carta del bar
 */
class CartaController extends AbstractController
{
    /**
     * Muestra la página principal de la carta.
     *
     * @param PlatoRepository  $platoRepository   Repositorio de platos.
     * @param BebidaRepository $bebidaRepository  Repositorio de bebidas.
     *
     * @return Response Respuesta HTTP que representa la página de la carta.
     *
     * @Route('/carta', name: 'app_carta')
     */
    #[Route('/carta', name: 'app_carta')]
    public function index(PlatoRepository $platoRepository, BebidaRepository $bebidaRepository): Response
    {
        //Obtiene todos los platos del repositorio platos
        $platos = $platoRepository->findAll();
        //Obtiene todas las bebidas del repositorio bebidas
        $bebidas = $bebidaRepository->findAll();

        return $this->render('carta/index.html.twig', [
            'controller_name' => 'CartaController',
            'platos' => $platos,
            'bebidas' => $bebidas
        ]);
    }
}
