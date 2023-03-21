<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ReciboRepository;
use DateInterval;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: ReciboRepository::class)]
class Recibo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?Hospedagem $hospedagem = null;



    #[ORM\Column(length: 255)]
    private ?string $cachorro_dono = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $tempo_total = null;

    #[ORM\OneToOne(mappedBy: 'recibo', cascade: ['persist', 'remove'])]
    private ?Hospedagem $hospedagem = null;

     public function getId(): ?int
    {
        return $this->id;
    }

    // public function getHospedagem(): ?Hospedagem
    // {
    //     return $this->hospedagem;
    // }

    // public function setHospedagem(Hospedagem $hospedagem): self
    // {
    //     $this->hospedagem = $hospedagem;

    //     return $this;
    // }


    public function getCachorroDono(): ?string
    {
        return $this->cachorro_dono;
    }

    public function setCachorroDono(): self
    {
        $cachorro = $this->hospedagem->getCachorro();
        $dono = $cachorro->getDono();
        $this->cachorro_dono = $cachorro . '/' . $dono;
     
        return $this;
    }

   
    public function getTempoTotal(): ?\DateTimeInterface
    {
        return $this->tempo_total;
    }

    public function setTempoTotal(\DateTimeInterface $tempo_total): self
    {
        $this->tempo_total = $tempo_total;

        return $this;
    }

    public function getHospedagem(): ?Hospedagem
    {
        return $this->hospedagem;
    }

    public function setHospedagem(?Hospedagem $hospedagem): self
    {
        // unset the owning side of the relation if necessary
        if ($hospedagem === null && $this->hospedagem !== null) {
            $this->hospedagem->setRecibo(null);
        }

        // set the owning side of the relation if necessary
        if ($hospedagem !== null && $hospedagem->getRecibo() !== $this) {
            $hospedagem->setRecibo($this);
        }

        $this->hospedagem = $hospedagem;

        return $this;
    }

    

}
