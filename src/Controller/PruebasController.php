<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PruebasController extends AbstractController
{
    #[Route('/pruebas', name: 'app_pruebas')]
    public function index(): Response
    {
        return $this->render('pruebas/index.html.twig', [
            'controller_name' => 'PruebasController',
        ]);
    }
}
