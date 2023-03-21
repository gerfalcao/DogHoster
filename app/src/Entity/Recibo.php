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

     #[ORM\Column(length: 255)]
    private ?string $cachorro_dono = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateInterval $tempo_total = null;

    #[ORM\OneToOne(mappedBy: 'recibo', cascade: ['persist', 'remove'])]
    private ?Hospedagem $hospedagem = null;

    #[ORM\Column(nullable: true)]
    private ?float $preco_servicos = null;

    #[ORM\Column]
    private ?float $preco_diaria = null;

    #[ORM\Column]
    private ?float $preco_total = null;

     public function getId(): ?int
    {
        return $this->id;
    }
 

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

   
    public function getTempoTotal(): ?\DateInterval
    {
        return $this->tempo_total;
    }

    public function setTempoTotal()
    {
        $this->tempo_total = $this->hospedagem->getDuration();
        
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

    public function getPrecoServicos(): ?float
    {
        return $this->preco_servicos;
    }

    public function setPrecoServicos()
    {
        $this->preco_servicos = $this->hospedagem->calcularTotalServicos();

        return $this;
    }

    public function getPrecoDiaria(): ?float
    {
        return $this->preco_diaria;
    }

    public function setPrecoDiaria()
    {
        $this->preco_diaria = $this->hospedagem->calcularTotalDiarias();

        return $this;
    }

    public function getPrecoTotal(): ?float
    {
        return $this->preco_total;
    }

    public function setPrecoTotal()
    {
        $this->preco_total = $this->hospedagem->calcularPreco();

        return $this;
    }

    

}
