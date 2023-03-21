<?php

namespace App\Entity;

use App\Repository\OcorrenciasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OcorrenciasRepository::class)]
class Ocorrencias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ocorrencia = null;

    #[ORM\ManyToOne(inversedBy: 'ocorrencias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hospedagem $hospedagem = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOcorrencia(): ?string
    {
        return $this->ocorrencia;
    }

    public function setOcorrencia(string $ocorrencia): self
    {
        $this->ocorrencia = $ocorrencia;

        return $this;
    }

    public function getHospedagem(): ?Hospedagem
    {
        return $this->hospedagem;
    }

    public function setHospedagem(?Hospedagem $hospedagem): self
    {
        $this->hospedagem = $hospedagem;

        return $this;
    }
}
