<?php

namespace App\Controller;

use App\Repository\BebidaRepository;
use App\Repository\PlatoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgotarController extends AbstractController
{

    private $platoRepository;
    private $bebidaRepository;

    public function __construct(PlatoRepository $platoRepository, BebidaRepository $bebidaRepository)
    {
        $this->platoRepository = $platoRepository;
        $this->bebidaRepository = $bebidaRepository;
    }

    #[Route('/agotarPlatos', name: 'app_agotar_platos')]
    public function agotarPlatos(): Response
    {
        $platos = $this->platoRepository->findAll();

        return $this->render('agotar/platos.html.twig', [
            'controller_name' => 'AgotarController',
            'platos' => $platos
        ]);
    }

    #[Route('/agotarBebidas', name: 'app_agotar_bebidas')]
    public function agotarBebidas(): Response
    {
        $bebidas = $this->bebidaRepository->findAll();

        return $this->render('agotar/bebidas.html.twig', [
            'controller_name' => 'AgotarController',
            'bebidas' => $bebidas
        ]);
    }

    #[Route('/cambiar_disponibilidad_plato/{id}', name: 'app_cambiar_disponibilidad_plato', methods: 'POST')]
    public function cambiarDisponibilidadPlato(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);
        if ($data['agotado'] == false) {
            $plato = $this->platoRepository->find($id);
            $plato->setAgotado(false);
            $entityManager->flush();
        }

        if ($data['agotado'] == true) {
            $plato = $this->platoRepository->find($id);
            $plato->setAgotado(true);
            $entityManager->flush();
        }


        return new JsonResponse(['message' => 'La disponibilidad del plato se actualizó correctamente.', 'agotado' => $plato->isAgotado()]);
    }

    #[Route('/cambiar_disponibilidad_bebida/{id}', name: 'app_cambiar_disponibilidad_bebida', methods: 'POST')]
    public function cambiarDisponibilidadBebida(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);
        if ($data['agotado'] == false) {
            $bebida = $this->bebidaRepository->find($id);
            $bebida->setAgotado(false);
            $entityManager->flush();
        }

        if ($data['agotado'] == true) {
            $bebida = $this->bebidaRepository->find($id);
            $bebida->setAgotado(true);
            $entityManager->flush();
        }


        return new JsonResponse(['message' => 'La disponibilidad de la bebida se actualizó correctamente.', 'agotado' => $bebida->isAgotado()]);
    }
}
