<?php

namespace App\Entity;

use App\Repository\TrabajadorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrabajadorRepository::class)]
class Trabajador
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Apellidos = null;

    #[ORM\Column(length: 255)]
    private ?string $DNI = null;

    #[ORM\OneToMany(mappedBy: 'Trabajador', targetEntity: Presencia::class)]
    private Collection $presencias;

    #[ORM\OneToMany(mappedBy: 'Trabajador', targetEntity: Comanda::class)]
    private Collection $comandas;

    public function __construct()
    {
        $this->presencias = new ArrayCollection();
        $this->comandas = new ArrayCollection();
    }

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

    public function getApellidos(): ?string
    {
        return $this->Apellidos;
    }

    public function setApellidos(string $Apellidos): self
    {
        $this->Apellidos = $Apellidos;

        return $this;
    }

    public function getDNI(): ?string
    {
        return $this->DNI;
    }

    public function setDNI(string $DNI): self
    {
        $this->DNI = $DNI;

        return $this;
    }

    /**
     * @return Collection<int, Presencia>
     */
    public function getPresencias(): Collection
    {
        return $this->presencias;
    }

    public function addPresencia(Presencia $presencia): self
    {
        if (!$this->presencias->contains($presencia)) {
            $this->presencias->add($presencia);
            $presencia->setTrabajador($this);
        }

        return $this;
    }

    public function removePresencia(Presencia $presencia): self
    {
        if ($this->presencias->removeElement($presencia)) {
            // set the owning side to null (unless already changed)
            if ($presencia->getTrabajador() === $this) {
                $presencia->setTrabajador(null);
            }
        }

        return $this;
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
            $comanda->setTrabajador($this);
        }

        return $this;
    }

    public function removeComanda(Comanda $comanda): self
    {
        if ($this->comandas->removeElement($comanda)) {
            // set the owning side to null (unless already changed)
            if ($comanda->getTrabajador() === $this) {
                $comanda->setTrabajador(null);
            }
        }

        return $this;
    }
}
