<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $emplacement = null;

    #[ORM\OneToMany(mappedBy: 'stock', targetEntity: Exemplaire::class)]
    private Collection $livre;

    #[ORM\OneToMany(mappedBy: 'Livre', targetEntity: Exemplaire::class)]
    private Collection $exemplaires;

    public function __construct()
    {
        $this->livre = new ArrayCollection();
        $this->exemplaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getLivre(): Collection
    {
        return $this->livre;
    }

    public function addLivre(Exemplaire $livre): self
    {
        if (!$this->livre->contains($livre)) {
            $this->livre->add($livre);
            $livre->setStock($this);
        }

        return $this;
    }

    public function removeLivre(Exemplaire $livre): self
    {
        if ($this->livre->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getStock() === $this) {
                $livre->setStock(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getExemplaires(): Collection
    {
        return $this->exemplaires;
    }

    public function addExemplaire(Exemplaire $exemplaire): self
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires->add($exemplaire);
            $exemplaire->setLivre($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): self
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getLivre() === $this) {
                $exemplaire->setLivre(null);
            }
        }

        return $this;
    }
}
