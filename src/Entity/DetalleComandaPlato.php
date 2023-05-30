<?php

namespace App\Entity;

use App\Repository\DetalleComandaPlatoRepository;
use Doctrine\ORM\Mapping as ORM;

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
    private ?Plato $plato = null;

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
}
