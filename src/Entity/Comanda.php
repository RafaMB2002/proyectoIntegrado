<?php

namespace App\Entity;

use App\Repository\ComandaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComandaRepository::class)]
class Comanda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaHoraInicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $FechaHoraFin = null;

    #[ORM\OneToMany(mappedBy: 'comanda', targetEntity: DetalleComanda::class)]
    private Collection $DetalleComanda;

    #[ORM\ManyToOne(inversedBy: 'comandas')]
    private ?Mesa $Mesa = null;

    #[ORM\ManyToOne(inversedBy: 'comandas')]
    private ?Trabajador $Trabajador = null;

    #[ORM\Column(nullable: true)]
    private ?float $Precio_total = null;

    public function __construct()
    {
        $this->DetalleComanda = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHoraInicio(): ?\DateTimeInterface
    {
        return $this->FechaHoraInicio;
    }

    public function setFechaHoraInicio(\DateTimeInterface $FechaHoraInicio): self
    {
        $this->FechaHoraInicio = $FechaHoraInicio;

        return $this;
    }

    public function getFechaHoraFin(): ?\DateTimeInterface
    {
        return $this->FechaHoraFin;
    }

    public function setFechaHoraFin(?\DateTimeInterface $FechaHoraFin): self
    {
        $this->FechaHoraFin = $FechaHoraFin;

        return $this;
    }

    /**
     * @return Collection<int, DetalleComanda>
     */
    public function getDetalleComanda(): Collection
    {
        return $this->DetalleComanda;
    }

    public function addDetalleComanda(DetalleComanda $detalleComanda): self
    {
        if (!$this->DetalleComanda->contains($detalleComanda)) {
            $this->DetalleComanda->add($detalleComanda);
            $detalleComanda->setComanda($this);
        }

        return $this;
    }

    public function removeDetalleComanda(DetalleComanda $detalleComanda): self
    {
        if ($this->DetalleComanda->removeElement($detalleComanda)) {
            // set the owning side to null (unless already changed)
            if ($detalleComanda->getComanda() === $this) {
                $detalleComanda->setComanda(null);
            }
        }

        return $this;
    }

    public function getMesa(): ?Mesa
    {
        return $this->Mesa;
    }

    public function setMesa(?Mesa $Mesa): self
    {
        $this->Mesa = $Mesa;

        return $this;
    }

    public function getTrabajador(): ?Trabajador
    {
        return $this->Trabajador;
    }

    public function setTrabajador(?Trabajador $Trabajador): self
    {
        $this->Trabajador = $Trabajador;

        return $this;
    }

    public function getPrecioTotal(): ?float
    {
        return $this->Precio_total;
    }

    public function setPrecioTotal(?float $Precio_total): self
    {
        $this->Precio_total = $Precio_total;

        return $this;
    }
}
