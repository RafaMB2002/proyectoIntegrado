<?php

namespace App\Entity;

use App\Repository\BebidaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BebidaRepository::class)]
class Bebida
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column]
    private ?float $Precio = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Descripcion = null;

    #[ORM\Column]
    private ?int $Stock = null;

    #[ORM\Column]
    private ?int $StockMin = null;

    #[ORM\Column]
    private ?int $StockMax = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Foto = null;

    #[ORM\ManyToOne(inversedBy: 'Bebida')]
    private ?DetalleComanda $detalleComanda = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->Precio;
    }

    public function setPrecio(float $Precio): self
    {
        $this->Precio = $Precio;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(string $Descripcion): self
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(int $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getStockMin(): ?int
    {
        return $this->StockMin;
    }

    public function setStockMin(int $StockMin): self
    {
        $this->StockMin = $StockMin;

        return $this;
    }

    public function getStockMax(): ?int
    {
        return $this->StockMax;
    }

    public function setStockMax(int $StockMax): self
    {
        $this->StockMax = $StockMax;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->Foto;
    }

    public function setFoto(string $Foto): self
    {
        $this->Foto = $Foto;

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
}
