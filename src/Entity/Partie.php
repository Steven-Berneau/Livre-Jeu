<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_partie = null;

    #[ORM\ManyToOne(inversedBy: 'parties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personnage $aventurier = null;

    #[ORM\ManyToOne(inversedBy: 'parties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aventure $aventure = null;

    #[ORM\ManyToOne(inversedBy: 'parties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etape $etape = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePartie(): ?\DateTimeInterface
    {
        return $this->date_partie;
    }

    public function setDatePartie(\DateTimeInterface $date_partie): static
    {
        $this->date_partie = $date_partie;

        return $this;
    }

    public function getAventurier(): ?Personnage
    {
        return $this->aventurier;
    }

    public function setAventurier(?Personnage $aventurier): static
    {
        $this->aventurier = $aventurier;

        return $this;
    }

    public function getAventure(): ?Aventure
    {
        return $this->aventure;
    }

    public function setAventure(?Aventure $aventure): static
    {
        $this->aventure = $aventure;

        return $this;
    }

    public function getEtape(): ?Etape
    {
        return $this->etape;
    }

    public function setEtape(?Etape $etape): static
    {
        $this->etape = $etape;

        return $this;
    }
}
