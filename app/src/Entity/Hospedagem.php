<?php

namespace App\Entity;

use App\Repository\HospedagemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: HospedagemRepository::class)]
class Hospedagem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_fim = null;

    #[ORM\Column]
    private ?bool $temBanho = null;

    #[ORM\Column]
    private ?bool $temAdestramento = null;

    #[ORM\ManyToOne(inversedBy: 'hospedagems')]
    private ?Cachorro $Cachorro = null;

   
    public function getId(): ?int
    {
        return $this->id;
    }



    public function getDataInicio(): ?\DateTimeInterface
    {
        return $this->data_inicio;
    }

    public function setDataInicio(\DateTimeInterface $data_inicio): self
    {
        $this->data_inicio = $data_inicio;

        return $this;
    }

    public function getDataFim(): ?\DateTimeInterface
    {
        return $this->data_fim;
    }

    public function setDataFim(\DateTimeInterface $data_fim): self
    {
        $this->data_fim = $data_fim;

        return $this;
    }

    public function isTemBanho(): ?bool
    {
        return $this->temBanho;
    }

    public function setTemBanho(bool $temBanho): self
    {
        $this->temBanho = $temBanho;

        return $this;
    }

    public function isTemAdestramento(): ?bool
    {
        return $this->temAdestramento;
    }

    public function setTemAdestramento(bool $temAdestramento): self
    {
        $this->temAdestramento = $temAdestramento;

        return $this;
    }

    public function getCachorro(): ?Cachorro
    {
        return $this->Cachorro;
    }

    public function setCachorro(?Cachorro $Cachorro): self
    {
        $this->Cachorro = $Cachorro;

        return $this;
    }

  
}
