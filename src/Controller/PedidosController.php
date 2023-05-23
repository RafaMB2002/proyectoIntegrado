<?php

namespace App\Controller;

use App\Repository\BebidaRepository;
use App\Repository\ComandaRepository;
use App\Repository\PlatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PedidosController extends AbstractController
{
    #[Route('/generarQR', name: 'generarQR')]
    public function generarQR(): Response
    {
        return $this->render('pedidos/qr.html.twig', [
            'controller_name' => 'PedidosController',
        ]);
    }

    #[Route('/pedidos', name: 'pedidos')]
    public function pedidos(PlatoRepository $platoRepository, BebidaRepository $bebidaRepository): Response
    {
        $platos = $platoRepository->findAll();
        $bebidas = $bebidaRepository->findAll();

        return $this->render('pedidos/pedidos.html.twig', [
            'controller_name' => 'PedidosController',
            'platos' => $platos,
            'bebidas' => $bebidas
        ]);
    }

    #[Route('/finalizarComanda', name: 'finalizarComanda')]
    public function finalizarComanda(ComandaRepository $comandaRepository): Response
    {
        $comandas = $comandaRepository->findAll();

        return $this->render('pedidos/finalizarComanda.html.twig', [
            'controller_name' => 'PedidosController',
            'comandas' => $comandas
        ]);
    }
}
