<?php

namespace App\Controller;

use App\Repository\BebidaRepository;
use App\Repository\PlatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListadoController extends AbstractController
{
    #[Route('/listadoPlatos', name: 'app_listado_platos')]
    public function listadoPlatos(PlatoRepository $platoRepository): Response
    {
        $platos = $platoRepository->findAll();
        return $this->render('listado/platos.html.twig', [
            'platos' => $platos,
        ]);
    }

    #[Route('/listadoBebidas', name: 'app_listado_bebidas')]
    public function listadoBebidas(BebidaRepository $bebidaRepository): Response
    {
        $bebidas = $bebidaRepository->findAll();
        return $this->render('listado/bebidas.html.twig', [
            'bebidas' => $bebidas,
        ]);
    }
}
