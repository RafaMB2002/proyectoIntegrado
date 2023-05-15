<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PedidosController extends AbstractController
{
    #[Route('/pedidos', name: 'app_pedidos')]
    public function index(): Response
    {
        return $this->render('pedidos/index.html.twig', [
            'controller_name' => 'PedidosController',
        ]);
    }
}
