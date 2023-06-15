<?php

namespace App\Controller;

use App\Entity\Comanda;
use App\Entity\DetalleComanda;
use App\Entity\DetalleComandaBebida;
use App\Entity\DetalleComandaPlato;
use App\Entity\Mesa;
use App\Entity\Plato;
use App\Entity\Trabajador;
use App\Repository\BebidaRepository;
use App\Repository\ComandaRepository;
use App\Repository\DetalleComandaBebidaRepository;
use App\Repository\DetalleComandaPlatoRepository;
use App\Repository\DetalleComandaRepository;
use App\Repository\MesaRepository;
use App\Repository\PlatoRepository;
use App\Repository\TrabajadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use \DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ComandaController extends AbstractController
{

    private $comandaRepository;
    private $mesaRepository;
    private $detalleComandaRepository;
    private $platoRepository;
    private $bebidaRepository;
    private $entityManager;
    private $urlGenerator;
    private $detalleComandaPlato;

    public function __construct(ComandaRepository $comandaRepository, MesaRepository $mesaRepository, DetalleComandaRepository $detalleComandaRepository, PlatoRepository $platoRepository, BebidaRepository $bebidaRepository, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, DetalleComandaPlato $detalleComandaPlato)
    {
        $this->comandaRepository = $comandaRepository;
        $this->mesaRepository = $mesaRepository;
        $this->detalleComandaRepository = $detalleComandaRepository;
        $this->platoRepository = $platoRepository;
        $this->bebidaRepository = $bebidaRepository;
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->detalleComandaPlato = $detalleComandaPlato;
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

    public function calcularTotal($id)
    {
        $precios = [];
        $comanda = $this->comandaRepository->find($id);
        foreach ($comanda->getDetalleComanda() as $detalleComanda) {
            foreach ($detalleComanda->getDetalleComandaPlato() as $detalleComandaPlato) {
                for ($i = 0; $i < $detalleComandaPlato->getCantidad(); $i++) {
                    array_push($precios, $detalleComandaPlato->getPlato()->getPrecio());
                }
            }
            foreach ($detalleComanda->getDetalleComandaBebida() as $detalleComandaBebida) {
                for ($i = 0; $i < $detalleComandaBebida->getCantidad(); $i++) {
                    array_push($precios, $detalleComandaBebida->getBebida()->getPrecio());
                }
            }
        }

        $preciosTotal = array_sum($precios);

        return $preciosTotal;
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
            $comanda->setPrecioTotal($this->calcularTotal($id));

            // Persistir los cambios en la base de datos
            $entityManager->flush();

            // Devolver la respuesta
            return $this->json(['message' => 'Comanda finalizada correctamente'], 200);
        } else {
            return $this->json(['error' => 'No se pudo actualizar'], 500);
        }
    }

    #[Route('/addPlatos/{id}', name: 'add_detalle_comanda_platos', methods: 'PATCH')]
    public function addDetalleComandaPlatos(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $detalleComanda = $this->detalleComandaRepository->find($id);
        $platos = json_decode($request->getContent(), true);

        foreach ($platos as $platoData) {
            $plato = $this->platoRepository->find($platoData['id']);
            $detalleComanda->addPlato($plato, $platoData['cantidad']);
        }

        $entityManager->persist($detalleComanda);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Platos agregados a la comanda'], 201);
    }

    #[Route('/addBebidas/{id}', name: 'add_detalle_comanda_bebidas', methods: 'PATCH')]
    public function addDetalleComandabebidas(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $detalleComanda = $this->detalleComandaRepository->find($id);
        $bebidas = json_decode($request->getContent(), true);

        foreach ($bebidas as $bebidaData) {
            $bebida = $this->bebidaRepository->find($bebidaData['id']);
            $detalleComanda->addBebida($bebida, $bebidaData['cantidad']);
        }

        $entityManager->persist($detalleComanda);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Bebidas agregadas a la comanda'], 201);
    }

    #[Route('/getPlatos/{id}', name: 'get_platos', methods: 'GET')]
    public function getPlatos(ComandaRepository $comandaRepository, DetalleComandaRepository $detalleComandaRepository, PlatoRepository $platoRepository, EntityManagerInterface $entityManager, BebidaRepository $bebidaRepository, $id): Response
    {
        $platos = [];
        $comanda = $comandaRepository->find($id);
        $detalleComandaCollecion = $comanda->getDetalleComanda();


        for ($i = 0; $i < count($detalleComandaCollecion); $i++) {
            $platos = $detalleComandaCollecion[$i]->getPlatos();
            foreach ($platos as $plato) {
                echo "Nombre: " . $plato->getNombre() . "\n";
                echo "Precio: " . $plato->getPrecio() . "\n";
                echo "\n\n";
            }
        }

        return new Response('Hecho!');
    }

    #[Route('/getBebidas/{id}', name: 'get_bebidas', methods: 'GET')]
    public function getBebidas(ComandaRepository $comandaRepository, DetalleComandaRepository $detalleComandaRepository, PlatoRepository $platoRepository, EntityManagerInterface $entityManager, BebidaRepository $bebidaRepository, $id): Response
    {
        $bebidas = [];
        $comanda = $comandaRepository->find($id);
        $detalleComandaCollecion = $comanda->getDetalleComanda();


        for ($i = 0; $i < count($detalleComandaCollecion); $i++) {
            $bebidas = $detalleComandaCollecion[$i]->getBebidas();
            foreach ($bebidas as $bebida) {
                echo "Nombre: " . $bebida->getNombre() . "\n";
                echo "Precio: " . $bebida->getPrecio() . "\n";
                echo "\n\n";
            }
        }

        return new Response('Hecho!');
    }

    #[Route('/crearDetalleComanda/{id}', name: 'crear_detalle_comanda', methods: 'GET')]
    public function createDetalleComanda($id)
    {
        $comanda = $this->comandaRepository->find($id);
        $detalleComanda = new DetalleComanda();
        $detalleComanda->setComanda($comanda);
        $this->entityManager->persist($detalleComanda);
        $this->entityManager->flush();

        $platos = $this->platoRepository->findAll();
        $bebidas = $this->bebidaRepository->findAll();

        return $this->render('pedidos/pedidos.html.twig', [
            'controller_name' => 'ComandaController',
            'platos' => $platos,
            'bebidas' => $bebidas,
            'idDetalleComanda' => $detalleComanda->getId()
        ]);
    }

    #[Route('/comandas2', name: 'comandas_cocina')]
    public function comandas2(EntityManagerInterface $entityManager, DetalleComandaPlatoRepository $detalleComandaPlatoRepository): Response
    {

        // Consulta para obtener las comandas activas con sus platos
        $query = $entityManager->createQuery('
        SELECT c, dc
        FROM App\Entity\Comanda c
        JOIN c.DetalleComanda dc
        WHERE c.FechaHoraFin IS NULL
');

        // Ejecutar la consulta y obtener los resultados
        $comandas = $query->getResult();

        $detalleComandaPlato = $detalleComandaPlatoRepository->findAll();

        return $this->render('comanda/comandas_disponibles_cocina.html.twig', [
            'comandas' => $comandas,
            'numDetalleComandaPlato' => count($detalleComandaPlato)
        ]);
    }

    #[Route('/comandas3', name: 'comandas_camarero')]
    public function comandas3(EntityManagerInterface $entityManager, DetalleComandaPlatoRepository $detalleComandaPlatoRepository, DetalleComandaBebidaRepository $detalleComandaBebidaRepository): Response
    {

        // Consulta para obtener las comandas activas con sus platos
        $query = $entityManager->createQuery('
        SELECT c, dc
        FROM App\Entity\Comanda c
        JOIN c.DetalleComanda dc
        WHERE c.FechaHoraFin IS NULL
');

        // Ejecutar la consulta y obtener los resultados
        $comandas = $query->getResult();

        $detalleComandaPlato = $detalleComandaPlatoRepository->findAll();
        $detalleComandaBebida = $detalleComandaBebidaRepository->findAll();

        return $this->render('comanda/comandas_disponibles_camarero.html.twig', [
            'comandas' => $comandas,
            'numDetalleComandaPlato' => count($detalleComandaPlato),
            'numDetalleComandaBebida' => count($detalleComandaBebida)
        ]);
    }

    #[Route('/obtener-comandas', name: 'obtener-comandas')]
    public function obtenerComandas(EntityManagerInterface $entityManager, DetalleComandaPlatoRepository $detalleComandaPlatoRepository): JsonResponse
    {

        $detalleComandaPlato = $detalleComandaPlatoRepository->findAll();


        // Devolver las comandas serializadas como respuesta JSON
        return new JsonResponse(count($detalleComandaPlato), 200, [], true);
    }

    #[Route('/obtener-comandas-camarero', name: 'obtener-comandas-camarero')]
    public function obtenerComandasCamarero(EntityManagerInterface $entityManager, DetalleComandaBebidaRepository $detalleComandaBebidaRepository): JsonResponse
    {

        $detalleComandaBebida = $detalleComandaBebidaRepository->findAll();


        // Devolver las comandas serializadas como respuesta JSON
        return new JsonResponse(count($detalleComandaBebida), 200, [], true);
    }



    #[Route('/marcar-finalizado', name: 'finalizar_comida', methods: 'POST')]
    public function marcarFinalizado(Request $request, EntityManagerInterface $entityManager)
    {
        $platoId = $request->request->get('id');

        $detalleComandaPlato = $entityManager->getRepository(DetalleComandaPlato::class)->find($platoId);

        if (!$detalleComandaPlato) {
            return new JsonResponse(['success' => false]);
        }

        $detalleComandaPlato->setFinalizado(true);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/marcar-entregar-bebida', name: 'entregar', methods: 'POST')]
    public function marcarEntregar(Request $request, EntityManagerInterface $entityManager)
    {
        $bebidaId = $request->request->get('id');

        $detalleComandaBebida = $entityManager->getRepository(DetalleComandaBebida::class)->find($bebidaId);

        if (!$detalleComandaBebida) {
            return new JsonResponse(['success' => false]);
        }

        $detalleComandaBebida->setEntregado(true);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/marcar-entregar-plato', name: 'entregar-plato', methods: 'POST')]
    public function marcarEntregarPlato(Request $request, EntityManagerInterface $entityManager)
    {
        $platoId = $request->request->get('id');

        $detalleComandaPlato = $entityManager->getRepository(DetalleComandaPlato::class)->find($platoId);

        if (!$detalleComandaPlato) {
            return new JsonResponse(['success' => false]);
        }

        $detalleComandaPlato->setEntregado(true);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
}
