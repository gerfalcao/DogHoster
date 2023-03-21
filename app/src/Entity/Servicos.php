<?php

namespace App\Entity;

use App\Repository\ServicosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicosRepository::class)]
class Servicos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column]
    private ?int $preco = null;

    #[ORM\Column]
    private ?int $quantidade = null;

    #[ORM\ManyToOne(inversedBy: 'servicos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hospedagem $hospedagem = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getPreco(): ?int
    {
        return $this->preco;
    }

    public function setPreco(int $preco): self
    {
        $this->preco = $preco;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;

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
