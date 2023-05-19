<?php

namespace App\Controller;

use App\Entity\Trabajador;
use App\Repository\TrabajadorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrabajadorController extends AbstractController
{
    #[Route('/trabajadores', name: 'new_trabajador', methods: 'POST')]
    public function createTrabajador(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $trabajador = new Trabajador();
        $nombre = $data['nombre'];
        $apellidos = $data['apellidos'];
        $dni = $data['dni'];

        $trabajador->setNombre($nombre)
            ->setApellidos($apellidos)
            ->setDNI($dni);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($trabajador);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json(['message' => 'Trabajador creado', 'id' => $trabajador->getId()]);
    }

    #[Route('/trabajadores', name: 'get_all_trabajadores', methods: 'GET')]
    public function listarTrabajadores(EntityManagerInterface $entityManager, TrabajadorRepository $trabajadorRepository): JsonResponse
    {
        $trabajadores = $trabajadorRepository->findAll();
        $data = [];

        foreach ($trabajadores as $trabajador) {
            $data[] = [
                'id' => $trabajador->getId(),
                'nombre' => $trabajador->getNombre(),
                'apellidos' => $trabajador->getApellidos(),
                'dni' => $trabajador->getDNI()
            ];
        }

        return $this->json($data);
    }
}
