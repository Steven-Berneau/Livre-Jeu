<?php

namespace App\Entity;

use App\Repository\AventureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AventureRepository::class)]
class Aventure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'aventureDebutee', cascade: ['persist', 'remove'])]
    private ?Etape $premiereEtape = null;

    /**
     * @var Collection<int, Etape>
     */
    #[ORM\OneToMany(targetEntity: Etape::class, mappedBy: 'aventure')]
    private Collection $etapes;

    /**
     * @var Collection<int, Etape>
     */
    #[ORM\OneToMany(targetEntity: Etape::class, mappedBy: 'finAventure')]
    private Collection $finsPossibles;

    /**
     * @var Collection<int, Partie>
     */
    #[ORM\OneToMany(targetEntity: Partie::class, mappedBy: 'aventure')]
    private Collection $parties;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
        $this->finsPossibles = new ArrayCollection();
        $this->parties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPremiereEtape(): ?Etape
    {
        return $this->premiereEtape;
    }

    public function setPremiereEtape(?Etape $premiereEtape): static
    {
        $this->premiereEtape = $premiereEtape;

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): static
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setAventure($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): static
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getAventure() === $this) {
                $etape->setAventure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getFinsPossibles(): Collection
    {
        return $this->finsPossibles;
    }

    public function addFinsPossible(Etape $finsPossible): static
    {
        if (!$this->finsPossibles->contains($finsPossible)) {
            $this->finsPossibles->add($finsPossible);
            $finsPossible->setFinAventure($this);
        }

        return $this;
    }

    public function removeFinsPossible(Etape $finsPossible): static
    {
        if ($this->finsPossibles->removeElement($finsPossible)) {
            // set the owning side to null (unless already changed)
            if ($finsPossible->getFinAventure() === $this) {
                $finsPossible->setFinAventure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Partie>
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Partie $party): static
    {
        if (!$this->parties->contains($party)) {
            $this->parties->add($party);
            $party->setAventure($this);
        }

        return $this;
    }

    public function removeParty(Partie $party): static
    {
        if ($this->parties->removeElement($party)) {
            // set the owning side to null (unless already changed)
            if ($party->getAventure() === $this) {
                $party->setAventure(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
