<?php

namespace App\Entity;

use App\Repository\CachorroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CachorroRepository::class)]
class Cachorro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column]
    private ?int $porte = null;

    #[ORM\Column]
    private ?float $agressividade = null;

    #[ORM\ManyToOne(inversedBy: 'Cachorro')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dono $dono = null;

    #[ORM\OneToMany(mappedBy: 'cachorro', targetEntity: Hospedagem::class)]
    private Collection $hospedagems;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    // #[ORM\OneToMany(mappedBy: 'Cachorro', targetEntity: Hospedagem::class)]
    // private Collection $hospedagems;

    public function __construct()
    {
        $this->hospedagems = new ArrayCollection();
    }


    public function __toString()
    {
       return $this->nome . ' / ' . $this->getDono();
    }    

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

    public function getPorte(): ?int
    {
        return $this->porte;
    }

    public function setPorte(int $porte): self
    {
        $this->porte = $porte;

        return $this;
    }

    public function getAgressividade(): ?float
    {
        return $this->agressividade;
    }

    public function setAgressividade(float $agressividade): self
    {
        $this->agressividade = $agressividade;

        return $this;
    }

    public function getDono(): ?Dono
    {
        return $this->dono;
    }

    public function setDono(?Dono $dono): self
    {
        $this->dono = $dono;

        return $this;
    }

    // /**
    //  * @return Collection<int, Hospedagem>
    //  */
    // public function getHospedagems(): Collection
    // {
    //     return $this->hospedagems;
    // }

    // public function addHospedagem(Hospedagem $hospedagem): self
    // {
    //     if (!$this->hospedagems->contains($hospedagem)) {
    //         $this->hospedagems->add($hospedagem);
    //         $hospedagem->setCachorro($this);
    //     }

    //     return $this;
    // }

    // public function removeHospedagem(Hospedagem $hospedagem): self
    // {
    //     if ($this->hospedagems->removeElement($hospedagem)) {
    //         // set the owning side to null (unless already changed)
    //         if ($hospedagem->getCachorro() === $this) {
    //             $hospedagem->setCachorro(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Hospedagem>
     */
    public function getHospedagems(): Collection
    {
        return $this->hospedagems;
    }

    public function addHospedagem(Hospedagem $hospedagem): self
    {
        if (!$this->hospedagems->contains($hospedagem)) {
            $this->hospedagems->add($hospedagem);
            $hospedagem->setCachorro($this);
        }

        return $this;
    }

    public function removeHospedagem(Hospedagem $hospedagem): self
    {
        if ($this->hospedagems->removeElement($hospedagem)) {
            // set the owning side to null (unless already changed)
            if ($hospedagem->getCachorro() === $this) {
                $hospedagem->setCachorro(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

 
   
}
