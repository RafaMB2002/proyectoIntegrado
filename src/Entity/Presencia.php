<?php

namespace App\Entity;

use App\Repository\PresenciaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenciaRepository::class)]
class Presencia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaHoraEntrada = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $FechaHoraSalida = null;

    #[ORM\ManyToOne(inversedBy: 'presencias')]
    private ?Trabajador $Trabajador = null;

    #[ORM\ManyToOne(inversedBy: 'Presencia')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHoraEntrada(): ?\DateTimeInterface
    {
        return $this->FechaHoraEntrada;
    }

    public function setFechaHoraEntrada(\DateTimeInterface $FechaHoraEntrada): self
    {
        $this->FechaHoraEntrada = $FechaHoraEntrada;

        return $this;
    }

    public function getFechaHoraSalida(): ?\DateTimeInterface
    {
        return $this->FechaHoraSalida;
    }

    public function setFechaHoraSalida(\DateTimeInterface $FechaHoraSalida): self
    {
        $this->FechaHoraSalida = $FechaHoraSalida;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
