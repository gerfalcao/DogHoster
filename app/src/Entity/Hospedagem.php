<?php

namespace App\Entity;

use App\Repository\HospedagemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: HospedagemRepository::class)]
class Hospedagem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_fim = null;

    
    #[ORM\OneToOne(inversedBy: 'hospedagem', cascade: ['persist', 'remove'])]
    private ?Recibo $recibo = null;

    #[ORM\ManyToOne(inversedBy: 'hospedagems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cachorro $cachorro = null;

    #[ORM\OneToMany(mappedBy: 'hospedagem', targetEntity: Servicos::class, orphanRemoval: true)]
    private Collection $servicos;

    public function __construct()
    {
        $this->servicos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->cachorro;
    }
   
   
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

    public function setDataFim(?\DateTimeInterface $data_fim): self
    {
        $this->data_fim = $data_fim;

        return $this;
    }

   
    public function getRecibo(): ?Recibo
    {
        return $this->recibo;
    }

    public function setRecibo(?Recibo $recibo): self
    {
        $this->recibo = $recibo;

        return $this;
    }

    public function getCachorro(): ?Cachorro
    {
        return $this->cachorro;
    }

    public function setCachorro(?Cachorro $cachorro): self
    {
        $this->cachorro = $cachorro;

        return $this;
    }

    public function getDuration(): \DateInterval
    {   
        $duration = $this->data_inicio->diff(new DateTime);
        return $duration;
    }

    public function calcularPreco(){
        $total_minutos = ($this->getDuration()->days * 24 * 60) + ($this->getDuration()->h *60) + $this->getDuration()->i;
        $num_diarias_completas = floor($total_minutos / (24 * 60));
        $num_diarias_parciais = ceil(($total_minutos % (24 * 60)) / 60);
 
        $valor_diaria = 30;
        $valor_total = ($num_diarias_completas + ($num_diarias_parciais > 0 ? 1 : 0)) * $valor_diaria;
        return $valor_total;
     }

    /**
     * @return Collection<int, Servicos>
     */
    public function getServicos(): Collection
    {
        return $this->servicos;
    }

    public function addServico(Servicos $servico): self
    {
        if (!$this->servicos->contains($servico)) {
            $this->servicos->add($servico);
            $servico->setHospedagem($this);
        }

        return $this;
    }

    public function removeServico(Servicos $servico): self
    {
        if ($this->servicos->removeElement($servico)) {
            // set the owning side to null (unless already changed)
            if ($servico->getHospedagem() === $this) {
                $servico->setHospedagem(null);
            }
        }

        return $this;
    }

}
