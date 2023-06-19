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

    #[ORM\OneToMany(mappedBy: 'Mesa', targetEntity: Comanda::class)]
    private Collection $comandas;

    #[ORM\Column(nullable: true)]
    private ?int $Comensales = null;

    public function __construct()
    {
        $this->comandas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Comanda>
     */
    public function getComandas(): Collection
    {
        return $this->comandas;
    }

    public function addComanda(Comanda $comanda): self
    {
        if (!$this->comandas->contains($comanda)) {
            $this->comandas->add($comanda);
            $comanda->setMesa($this);
        }

        return $this;
    }

    public function removeComanda(Comanda $comanda): self
    {
        if ($this->comandas->removeElement($comanda)) {
            // set the owning side to null (unless already changed)
            if ($comanda->getMesa() === $this) {
                $comanda->setMesa(null);
            }
        }

        return $this;
    }

    public function getComensales(): ?int
    {
        return $this->Comensales;
    }

    public function setComensales(?int $Comensales): static
    {
        $this->Comensales = $Comensales;

        return $this;
    }
}
