<?php

namespace App\Controller;

use App\Repository\BebidaRepository;
use App\Repository\ComandaRepository;
use App\Repository\PlatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PedidosController extends AbstractController
{

    private $comandaRepository;
    /**
     * Constructor
     * @param ComandaRepository $comandaRepository repositorio de la entidad comanda
     */
    public function __construct(ComandaRepository $comandaRepository)
    {
        $this->comandaRepository = $comandaRepository;
    }
    /**
     * Me lleva a la plantilla que genera el QR
     */
    #[Route('/generarQR', name: 'generarQR')]
    public function generarQR(): Response
    {
        return $this->render('pedidos/qr.html.twig', [
            'controller_name' => 'PedidosController',
        ]);
    }

    /**
     * Me lleva a la plantilla para finalizar las comandas
     * Obtengo todas las comandas desde el repositorio
     */
    #[Route('/finalizarComanda', name: 'finalizarComanda')]
    public function finalizarComanda(): Response
    {
        $comandas = $this->comandaRepository->findAll();

        return $this->render('pedidos/finalizarComanda.html.twig', [
            'controller_name' => 'PedidosController',
            'comandas' => $comandas
        ]);
    }

    /**
     * Funcion para imprimir una factura
     * Obtengo una comanda por ID
     */
    #[Route('/factura/{id}', name: 'factura', methods:'get')]
    public function imprimirFactura($id): Response
    {
        // Obtener la comanda desde la base de datos (asumiendo que tienes un repositorio ComandaRepository)
        $comanda = $this->comandaRepository->find($id);
        //dd($comanda->getDetalleComanda());

        if (!$comanda) {
            throw $this->createNotFoundException('Comanda no encontrada');
        }

        // Generar la factura utilizando los datos de la comanda y guardarla en una variable
        $facturaHTML = $this->renderView('pedidos/factura.html.twig', [
            'comanda' => $comanda,
        ]);

        // Devolver una respuesta con el contenido de la factura en formato HTML
        return new Response($facturaHTML, Response::HTTP_OK, ['Content-Type' => 'text/html']);
    }
}
