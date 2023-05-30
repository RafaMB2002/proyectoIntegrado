<?php

namespace App\Controller;

use App\Entity\Comanda;
use App\Entity\DetalleComanda;
use App\Entity\DetalleComandaPlato;
use App\Entity\Mesa;
use App\Entity\Plato;
use App\Entity\Trabajador;
use App\Repository\BebidaRepository;
use App\Repository\ComandaRepository;
use App\Repository\DetalleComandaRepository;
use App\Repository\MesaRepository;
use App\Repository\PlatoRepository;
use App\Repository\TrabajadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use \DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ComandaController extends AbstractController
{

    private $comandaRepository;
    private $mesaRepository;
    private $detalleComandaRepository;
    private $platoRepository;
    private $bebidaRepository;

    public function __construct(ComandaRepository $comandaRepository, MesaRepository $mesaRepository, DetalleComandaRepository $detalleComandaRepository, PlatoRepository $platoRepository, BebidaRepository $bebidaRepository)
    {
        $this->comandaRepository = $comandaRepository;
        $this->mesaRepository = $mesaRepository;
        $this->detalleComandaRepository = $detalleComandaRepository;
        $this->platoRepository = $platoRepository;
        $this->bebidaRepository = $bebidaRepository;
    }

    public function comandaExist($fechaHoraInicio, $idMesa)
    {
        $bool = true;

        $comandaExistente = $this->comandaRepository->createQueryBuilder('c')
            ->join('c.Mesa', 'm')
            ->where('m.id = :mesaId')
            ->andWhere('c.FechaHoraFin IS NULL')
            ->setParameter('mesaId', $idMesa)
            ->getQuery()
            ->getResult();

        //dd($comandaExistente);

        if (empty($comandaExistente)) {
            $bool = false;
        }

        return $bool;
    }

    #[Route('/comandas', name: 'new_comanda', methods: 'POST')]
    public function crearComanda(Request $request, EntityManagerInterface $entityManager, TrabajadorRepository $trabajadorRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $comanda = new Comanda();
        $idMesa = $data['idMesa'];
        $idTrabajador = $data['idTrabajador'];

        $hora_actual = DateTime::createFromFormat('d-m-Y H:i:s', date('d-m-Y H:i:s'));

        if ($this->comandaExist($hora_actual, $idMesa)) {
            return $this->json(['ocupado' => 1]);
        } else {
            $comanda->setFechaHoraInicio($hora_actual)
                ->setMesa($this->mesaRepository->find($idMesa))
                ->setTrabajador($trabajadorRepository->find($idTrabajador));

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($comanda);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->json(['ocupado' => 0, 'message' => 'Comanda creada', 'id' => $comanda->getId(), 'mesaId' => $comanda->getMesa()->getId()]);
        }
    }

    #[Route('/comandas', name: 'get_all_comandas', methods: 'GET')]
    public function listarComandas(EntityManagerInterface $entityManager, ComandaRepository $comandaRepository): JsonResponse
    {
        $comandas = $comandaRepository->findAll();
        $data = [];

        foreach ($comandas as $comanda) {
            $data[] = [
                'id' => $comanda->getId(),
                'fecha_hora_inicio' => $comanda->getFechaHoraInicio(),
                'fecha_hora_fin' => $comanda->getFechaHoraFin(),
                'mesa_id' => $comanda->getMesa()->getId(),
                'trabajador_id' => $comanda->getTrabajador()->getId(),
                'precio_total' => $comanda->getPrecioTotal()
            ];
        }

        return $this->json($data);
    }

    #[Route('/comandas/{id}', name: 'get_comanda_by_id', methods: 'GET')]
    public function obtenerComandaPorId(EntityManagerInterface $entityManager, ComandaRepository $comandaRepository, $id): JsonResponse
    {
        $comanda = $comandaRepository->find($id);

        if (!$comanda) {
            return $this->json(['error' => 'Producto no encontrado'], 404);
        }

        $data = [
            'id' => $comanda->getId(),
            'fecha_hora_inicio' => $comanda->getFechaHoraInicio(),
            'fecha_hora_fin' => $comanda->getFechaHoraFin(),
            'mesa_id' => $comanda->getMesa()->getId(),
            'trabajador_id' => $comanda->getTrabajador()->getId(),
            'precio_total' => $comanda->getPrecioTotal()
        ];

        return $this->json($data);
    }

    #[Route('/comandas/{id}', name: 'finalizar_comanda_by_id', methods: 'PATCH')]
    public function finalizarComandaPorId(Request $request, EntityManagerInterface $entityManager, ComandaRepository $comandaRepository, $id): JsonResponse
    {
        $comanda = $comandaRepository->find($id);

        if (!$comanda) {
            return $this->json(['error' => 'Comanda no encontrado'], 404);
        }

        $data = json_decode($request->getContent(), true);

        // Actualizar solo los campos proporcionados en la solicitud PATCH
        if (isset($data['fechaHoraFin'])) {
            $comanda->setFechaHoraFin(new DateTime($data['fechaHoraFin']));

            // Persistir los cambios en la base de datos
            $entityManager->flush();

            // Devolver la respuesta
            return $this->json(['message' => 'Comanda finalizada correctamente'], 200);
        } else {
            return $this->json(['error' => 'No se pudo actualizar'], 500);
        }
    }

    #[Route('/addPlatos/{id}', name: 'add_detalle_comanda', methods:'POST')]
    public function addDetalleComanda(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $detalleComanda = 's';
        $platos = json_decode($request->getContent(), true);

        foreach ($platos as $platoData) {
            $plato = $this->platoRepository->find($platoData['id']);
            $detalleComanda->addPlato($plato, $platoData['cantidad']);
        }

        $entityManager->persist($detalleComanda);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Platos agregados a la comanda'], 201);
    }

    #[Route('/getPlatos', name: 'get_platos')]
    public function getPlatos(ComandaRepository $comandaRepository, DetalleComandaRepository $detalleComandaRepository, PlatoRepository $platoRepository, EntityManagerInterface $entityManager, BebidaRepository $bebidaRepository): Response
    {
        $platos = [];
        $comanda = $comandaRepository->find(19);
        $detalleComandaCollecion = $comanda->getDetalleComanda();
        $platos = $detalleComandaCollecion[0]->getPlatos();


        foreach ($platos as $plato) {
            echo "Nombre: " . $plato->getNombre() . "\n";
            echo "Precio: " . $plato->getPrecio() . "\n";
            echo "\n";
        }
        return new Response('Hecho!');
    }

    public function createDetalleComanda(){
        
    }
}
