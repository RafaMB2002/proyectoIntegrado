<?php

namespace App\Controller;

use App\Repository\PresenciaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistroHorasController extends AbstractController
{
    #[Route('/registro/horas', name: 'app_registro_horas')]
    public function index(PresenciaRepository $presenciaRepository): Response
    {
        return $this->render('registro_horas/index.html.twig', [
            'controller_name' => 'RegistroHorasController',
            'presencias' => $presenciaRepository->findAll()
        ]);
    }
}
