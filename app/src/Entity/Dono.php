<?php

namespace App\Entity;

use App\Repository\DonoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonoRepository::class)]
class Dono
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'dono', targetEntity: Cachorro::class, orphanRemoval: true, cascade:['persist'])]
    private Collection $Cachorro;

    public function __construct()
    {
        $this->Cachorro = new ArrayCollection();
    }

    public function __toString(){
        return $this->nome;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Cachorro>
     */
    public function getCachorro(): Collection
    {
        return $this->Cachorro;
    }

    public function addCachorro(Cachorro $cachorro): self
    {
        if (!$this->Cachorro->contains($cachorro)) {
            $this->Cachorro->add($cachorro);
            $cachorro->setDono($this);
        }

        return $this;
    }

    public function removeCachorro(Cachorro $cachorro): self
    {
        if ($this->Cachorro->removeElement($cachorro)) {
            // set the owning side to null (unless already changed)
            if ($cachorro->getDono() === $this) {
                $cachorro->setDono(null);
            }
        }

        return $this;
    }
}
