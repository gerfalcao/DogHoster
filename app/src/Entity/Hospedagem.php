<?php

namespace App\Entity;

use Constants\HospedagemConstants;
use App\Repository\HospedagemRepository;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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

    #[ORM\OneToMany(mappedBy: 'hospedagem', targetEntity: Ocorrencias::class, orphanRemoval: true)]
    private Collection $ocorrencias;

     public function getEstado(): string
    {
        if(is_null($this->getDataFim())){
            return HospedagemConstants::ESTADO_ABERTO;
        } else {
            return HospedagemConstants::ESTADO_FECHADO;
        }
        // return $this->estado;
    }


    public function __construct()
    {
        $this->servicos = new ArrayCollection();
        $this->ocorrencias = new ArrayCollection();
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

    public function getPeriodo(): \DateInterval
    {   
        if (is_null($this->getDataFim())) {

            return $this->getDataInicio()->diff(new DateTime());;
        } else { 

            return $this->getDataInicio()->diff($this->getDataFim());
        };
       
    }

    public function calcTotalPeriodos() {
        $diasEmHoras = $this->getPeriodo()->d * 24;
        $horas = $this->getPeriodo()->h + $diasEmHoras;
        $minutos = $this->getPeriodo()->i;

        $periodo = $horas / HospedagemConstants::HORAS_POR_PERIODO + (ceil($minutos% HospedagemConstants::HORAS_POR_PERIODO) > 0 ? 1 : 0);
        return $periodo;

    }

    public function calcularTotalServicos() {
        $valor_total_servicos = 0;
        foreach ($this->servicos as $servico) { 
            $valor_total_servicos += $servico->calculaQuantidadePorPreco();
        };
        return $valor_total_servicos;
    }

    public function calcularPrecoEstadia() {
        $precoAgressividade = (($this->getCachorro()->getAgressividade()) / 100) * 10;
        $precoPorte = ($this->getCachorro()->getPorte() - 1) * 5;
        $precoEstadia = $this->calcTotalPeriodos() * (HospedagemConstants::VALOR_PERIODO + $precoPorte + $precoAgressividade);
        return $precoEstadia;
    }

    public function calcularPrecoTotal() {
        return $this->calcularTotalServicos() + $this->calcularPrecoEstadia();
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

    /**
     * @return Collection<int, Ocorrencias>
     */
    public function getOcorrencias(): Collection
    {
        return $this->ocorrencias;
    }

    public function addOcorrencia(Ocorrencias $ocorrencia): self
    {
        if (!$this->ocorrencias->contains($ocorrencia)) {
            $this->ocorrencias->add($ocorrencia);
            $ocorrencia->setHospedagem($this);
        }

        return $this;
    }

    public function removeOcorrencia(Ocorrencias $ocorrencia): self
    {
        if ($this->ocorrencias->removeElement($ocorrencia)) {
            // set the owning side to null (unless already changed)
            if ($ocorrencia->getHospedagem() === $this) {
                $ocorrencia->setHospedagem(null);
            }
        }

        return $this;
    }

}
