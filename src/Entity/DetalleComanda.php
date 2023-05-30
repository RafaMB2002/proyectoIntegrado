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

    #[ORM\ManyToOne(inversedBy: 'DetalleComanda')]
    private ?Comanda $comanda = null;

    #[ORM\OneToMany(mappedBy: 'detalleComanda', targetEntity: DetalleComandaPlato::class, cascade: ['persist'])]
    private Collection $DetalleComandaPlato;

    #[ORM\OneToMany(mappedBy: 'detalleComanda', targetEntity: DetalleComandaBebida::class, cascade:['persist'])]
    private Collection $DetalleComandaBebida;

    public function __construct()
    {
        $this->DetalleComandaPlato = new ArrayCollection();
        $this->DetalleComandaBebida = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, DetalleComandaPlato>
     */
    public function getDetalleComandaPlato(): Collection
    {
        return $this->DetalleComandaPlato;
    }

    public function addDetalleComandaPlato(DetalleComandaPlato $detalleComandaPlato): self
    {
        if (!$this->DetalleComandaPlato->contains($detalleComandaPlato)) {
            $this->DetalleComandaPlato->add($detalleComandaPlato);
            $detalleComandaPlato->setDetalleComanda($this);
        }

        return $this;
    }

    public function removeDetalleComandaPlato(DetalleComandaPlato $detalleComandaPlato): self
    {
        if ($this->DetalleComandaPlato->removeElement($detalleComandaPlato)) {
            // set the owning side to null (unless already changed)
            if ($detalleComandaPlato->getDetalleComanda() === $this) {
                $detalleComandaPlato->setDetalleComanda(null);
            }
        }

        return $this;
    }

    /**
     * Agrega un plato a la comanda.
     * @param Plato $plato El plato a agregar.
     * @param int $cantidad La cantidad del plato.
     */
    public function addPlato(Plato $plato, int $cantidad = 1): void
    {
        $itemDetalleComanda = new DetalleComandaPlato();
        $itemDetalleComanda->setDetalleComanda($this);
        $itemDetalleComanda->setPlato($plato);
        $itemDetalleComanda->setCantidad($cantidad);

        $this->DetalleComandaPlato->add($itemDetalleComanda);
    }

    /**
     * Agrega varios platos a la comanda.
     * @param array $platos El array de platos a agregar.
     * Cada elemento del array debe ser un array asociativo con las claves "plato" (Plato) y "cantidad" (int).
     */
    public function addPlatos(array $platos): void
    {
        foreach ($platos as $platoData) {
            $plato = $platoData['plato'];
            $cantidad = $platoData['cantidad'];

            $itemDetalleComanda = new DetalleComandaPlato();
            $itemDetalleComanda->setDetalleComanda($this);
            $itemDetalleComanda->setPlato($plato);
            $itemDetalleComanda->setCantidad($cantidad);

            $this->DetalleComandaPlato->add($itemDetalleComanda);
        }
    }

    /**
     * Obtiene todos los platos asociados a la comanda.
     * @return array La lista de platos.
     */
    public function getPlatos(): array
    {
        $platos = [];

        foreach ($this->DetalleComandaPlato as $itemComanda) {
            $platos[] = $itemComanda->getPlato();
        }

        return $platos;
    }

    /**
     * @return Collection<int, DetalleComandaBebida>
     */
    public function getDetalleComandaBebida(): Collection
    {
        return $this->DetalleComandaBebida;
    }

    public function addDetalleComandaBebida(DetalleComandaBebida $detalleComandaBebida): self
    {
        if (!$this->DetalleComandaBebida->contains($detalleComandaBebida)) {
            $this->DetalleComandaBebida->add($detalleComandaBebida);
            $detalleComandaBebida->setDetalleComanda($this);
        }

        return $this;
    }

    public function removeDetalleComandaBebida(DetalleComandaBebida $detalleComandaBebida): self
    {
        if ($this->DetalleComandaBebida->removeElement($detalleComandaBebida)) {
            // set the owning side to null (unless already changed)
            if ($detalleComandaBebida->getDetalleComanda() === $this) {
                $detalleComandaBebida->setDetalleComanda(null);
            }
        }

        return $this;
    }

    /**
     * Agrega varias bebidas a la comanda.
     * @param array $bebidas El array de bebidas a agregar.
     * Cada elemento del array debe ser un array asociativo con las claves "bebida" (Bebida) y "cantidad" (int).
     */
    public function addBebidas(array $bebidas): void
    {
        foreach ($bebidas as $bebidaData) {
            $bebida = $bebidaData['plato'];
            $cantidad = $bebidaData['cantidad'];

            $itemDetalleComanda = new DetalleComandaBebida();
            $itemDetalleComanda->setDetalleComanda($this);
            $itemDetalleComanda->setBebida($bebida);
            $itemDetalleComanda->setCantidad($cantidad);

            $this->DetalleComandaBebida->add($itemDetalleComanda);
        }
    }

    /**
     * Obtiene todas las bebidas asociadas a la comanda.
     * @return array La lista de bebidas.
     */
    public function getBebidas(): array
    {
        $bebidas = [];

        foreach ($this->DetalleComandaBebida as $itemComanda) {
            $bebidas[] = $itemComanda->getBebida();
        }

        return $bebidas;
    }
}
