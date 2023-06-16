<?php

namespace App\Controller;

use App\Entity\Mesa;
use App\Repository\MesaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesaController extends AbstractController
{
    /**
     * Crea una nueva mesa.
     *
     * @Route("/mesa", name="create_mesa")
     * @param EntityManagerInterface $entityManager Interfaz para administrar entidades en la base de datos.
     * @return Response Respuesta HTTP indicando el éxito de la operación.
     */
    #[Route('/mesa', name: 'create_mesa')]
    public function createMesa(EntityManagerInterface $entityManager): Response
    {
        $mesa = new Mesa();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($mesa);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Guardada nueva mesa con id ' . $mesa->getId());
    }
    
    /**
     * Obtiene una mesa por su ID.
     *
     * @Route("/mesas/{id}", name="get_mesa_by_id", methods="GET")
     * @param EntityManagerInterface $entityManager Interfaz para administrar entidades en la base de datos.
     * @param MesaRepository $mesaRepository Repositorio de la entidad Mesa para realizar consultas.
     * @param int $id ID de la mesa a obtener.
     * @return JsonResponse Respuesta HTTP en formato JSON con los datos de la mesa encontrada.
     */
    #[Route('/mesas/{id}', name: 'get_mesa_by_id', methods: 'GET')]
    public function obtenerMesaPorId(EntityManagerInterface $entityManager, MesaRepository $mesaRepository, $id): JsonResponse
    {
        $mesa = $mesaRepository->find($id);

        if (!$mesa) {
            return $this->json(['error' => 'Producto no encontrado']);
        }

        $data = [
            'id' => $mesa->getId()
        ];

        return $this->json($data);
    }
}
