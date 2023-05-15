<?php

namespace App\Entity;

use App\Repository\MesaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MesaRepository::class)]
class Mesa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'Mesa', targetEntity: DetalleComanda::class)]
    private Collection $detalleComandas;

    public function __construct()
    {
        $this->detalleComandas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, DetalleComanda>
     */
    public function getDetalleComandas(): Collection
    {
        return $this->detalleComandas;
    }

    public function addDetalleComanda(DetalleComanda $detalleComanda): self
    {
        if (!$this->detalleComandas->contains($detalleComanda)) {
            $this->detalleComandas->add($detalleComanda);
            $detalleComanda->setMesa($this);
        }

        return $this;
    }

    public function removeDetalleComanda(DetalleComanda $detalleComanda): self
    {
        if ($this->detalleComandas->removeElement($detalleComanda)) {
            // set the owning side to null (unless already changed)
            if ($detalleComanda->getMesa() === $this) {
                $detalleComanda->setMesa(null);
            }
        }

        return $this;
    }
}
