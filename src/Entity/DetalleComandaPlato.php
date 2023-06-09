<?php

namespace App\Entity;

use App\Event\nuevoDetalleComandaPlatoEvent;
use App\Repository\DetalleComandaPlatoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;

#[ORM\Entity(repositoryClass: DetalleComandaPlatoRepository::class)]
class DetalleComandaPlato
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne(inversedBy: 'DetalleComandaPlato')]
    private ?DetalleComanda $detalleComanda = null;

    #[ORM\ManyToOne(inversedBy: 'DetalleComandaPlato')]
    #[Groups("detalleComandaPlato")]
    private ?Plato $plato = null;

    #[ORM\Column]
    private ?bool $finalizado = null;

    public function __construct()
    {
        $this->finalizado = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getDetalleComanda(): ?DetalleComanda
    {
        return $this->detalleComanda;
    }

    public function setDetalleComanda(?DetalleComanda $detalleComanda): self
    {
        $this->detalleComanda = $detalleComanda;

        return $this;
    }

    public function getPlato(): ?Plato
    {
        return $this->plato;
    }

    public function setPlato(?Plato $plato): self
    {
        $this->plato = $plato;

        return $this;
    }

    public function isFinalizado(): ?bool
    {
        return $this->finalizado;
    }

    public function setFinalizado(bool $finalizado): static
    {
        $this->finalizado = $finalizado;

        return $this;
    }
}
