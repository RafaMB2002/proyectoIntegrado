<?php

namespace App\Controller;

use App\Entity\Comanda;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use \DateTime;

class ComandaController extends AbstractController
{
    #[Route('/comanda', name: 'create_comanda')]
    public function createComanda(EntityManagerInterface $entityManager): Response
    {
        $comanda = new Comanda();

        $hora_actual = DateTime::createFromFormat('d-m-Y H:i:s', date('d-m-Y H:i:s'));

        $comanda->setFechaHoraInicio($hora_actual);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($comanda);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $comanda->getId());
    }
}
