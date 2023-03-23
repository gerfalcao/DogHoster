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

    #[ORM\OneToOne(mappedBy: 'recibo', cascade: ['persist', 'remove'])]
    private ?Hospedagem $hospedagem = null;

    #[ORM\Column(nullable: true)]
    private ?float $preco_servicos = null;

    #[ORM\Column]
    private ?float $preco_diaria = null;

    #[ORM\Column]
    private ?float $preco_total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_fechamento = null;

    #[ORM\Column(length: 255)]
    private ?string $tempo_total_ = null;

     public function getId(): ?int
    {
        return $this->id;
    }
 

    public function getIntervaloTempo ()
    {
        return $this->tempo_total_;
    }

    public function setIntervaloTempo ()
    {

        $this->tempo_total_ = $this->hospedagem->getPeriodo()->format('%a dias, %h horas, %i minutos');
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
        $this->preco_diaria = $this->hospedagem->calcularPrecoEstadia();

        return $this;
    }

    public function getPrecoTotal(): ?float
    {
        return $this->preco_total;
    }

    public function setPrecoTotal()
    {
        $this->preco_total = $this->hospedagem->calcularPrecoTotal();

        return $this;
    }

    public function getDataFechamento(): ?\DateTimeInterface
    {
        return $this->data_fechamento;
    }

    public function setDataFechamento()
    {
        $this->data_fechamento = $this->hospedagem->getDataFim();

        return $this;
    }

    

}
