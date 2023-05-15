<?php

namespace App\Entity;

use App\Repository\DetalleComandaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleComandaRepository::class)]
class DetalleComanda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $precioTotal = null;

    #[ORM\ManyToOne(inversedBy: 'DetalleComanda')]
    private ?Comanda $comanda = null;

    #[ORM\ManyToOne(inversedBy: 'detalleComandas')]
    private ?Mesa $Mesa = null;

    #[ORM\OneToMany(mappedBy: 'detalleComanda', targetEntity: Plato::class)]
    private Collection $Plato;

    #[ORM\OneToMany(mappedBy: 'detalleComanda', targetEntity: Bebida::class)]
    private Collection $Bebida;

    #[ORM\ManyToOne(inversedBy: 'detalleComandas')]
    private ?Trabajador $Trabajador = null;

    public function __construct()
    {
        $this->Plato = new ArrayCollection();
        $this->Bebida = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrecioTotal(): ?float
    {
        return $this->precioTotal;
    }

    public function setPrecioTotal(?float $precioTotal): self
    {
        $this->precioTotal = $precioTotal;

        return $this;
    }

    public function getComanda(): ?Comanda
    {
        return $this->comanda;
    }

    public function setComanda(?Comanda $comanda): self
    {
        $this->comanda = $comanda;

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

    /**
     * @return Collection<int, Plato>
     */
    public function getPlato(): Collection
    {
        return $this->Plato;
    }

    public function addPlato(Plato $plato): self
    {
        if (!$this->Plato->contains($plato)) {
            $this->Plato->add($plato);
            $plato->setDetalleComanda($this);
        }

        return $this;
    }

    public function removePlato(Plato $plato): self
    {
        if ($this->Plato->removeElement($plato)) {
            // set the owning side to null (unless already changed)
            if ($plato->getDetalleComanda() === $this) {
                $plato->setDetalleComanda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bebida>
     */
    public function getBebida(): Collection
    {
        return $this->Bebida;
    }

    public function addBebida(Bebida $bebida): self
    {
        if (!$this->Bebida->contains($bebida)) {
            $this->Bebida->add($bebida);
            $bebida->setDetalleComanda($this);
        }

        return $this;
    }

    public function removeBebida(Bebida $bebida): self
    {
        if ($this->Bebida->removeElement($bebida)) {
            // set the owning side to null (unless already changed)
            if ($bebida->getDetalleComanda() === $this) {
                $bebida->setDetalleComanda(null);
            }
        }

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
}
