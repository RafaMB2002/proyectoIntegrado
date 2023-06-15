<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SobreNosotrosController extends AbstractController
{
    #[Route('/sobre/nosotros', name: 'app_sobre_nosotros')]
    public function index(): Response
    {

        $datos = [
            'telefono' => '610 33 47 22',
            'correo' => 'ivanpancorbo69@gmail.com'
        ];

        return $this->render('sobre_nosotros/index.html.twig', [
            'controller_name' => 'SobreNosotrosController',
            'datos' => $datos
        ]);
    }
}
