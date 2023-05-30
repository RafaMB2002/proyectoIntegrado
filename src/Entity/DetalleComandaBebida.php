<?php

namespace App\Entity;

use App\Repository\DetalleComandaBebidaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleComandaBebidaRepository::class)]
class DetalleComandaBebida
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne(inversedBy: 'DetalleComandaBebida')]
    private ?DetalleComanda $detalleComanda = null;

    #[ORM\ManyToOne(inversedBy: 'DetalleComandaBebida')]
    private ?Bebida $bebida = null;

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

    public function getBebida(): ?Bebida
    {
        return $this->bebida;
    }

    public function setBebida(?Bebida $bebida): self
    {
        $this->bebida = $bebida;

        return $this;
    }
}
