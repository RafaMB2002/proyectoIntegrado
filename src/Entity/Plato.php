<?php

namespace App\Entity;

use App\Repository\PlatoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatoRepository::class)]
class Plato
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Descripcion = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ValoresNutricionales = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Alergenos = null;

    #[ORM\Column]
    private ?float $Precio = null;

    #[ORM\Column(length: 255)]
    private ?string $Tipo = null;

    #[ORM\ManyToOne(inversedBy: 'Plato')]
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

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(string $Descripcion): self
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    public function getValoresNutricionales(): ?string
    {
        return $this->ValoresNutricionales;
    }

    public function setValoresNutricionales(string $ValoresNutricionales): self
    {
        $this->ValoresNutricionales = $ValoresNutricionales;

        return $this;
    }

    public function getAlergenos(): ?string
    {
        return $this->Alergenos;
    }

    public function setAlergenos(string $Alergenos): self
    {
        $this->Alergenos = $Alergenos;

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

    public function getTipo(): ?string
    {
        return $this->Tipo;
    }

    public function setTipo(string $Tipo): self
    {
        $this->Tipo = $Tipo;

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
