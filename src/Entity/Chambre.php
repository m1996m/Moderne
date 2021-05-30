<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 */
class Chambre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacite;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Hospilisation::class, mappedBy="chambre")
     */
    private $hospilisations;

    public function __construct()
    {
        $this->hospilisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Hospilisation[]
     */
    public function getHospilisations(): Collection
    {
        return $this->hospilisations;
    }

    public function addHospilisation(Hospilisation $hospilisation): self
    {
        if (!$this->hospilisations->contains($hospilisation)) {
            $this->hospilisations[] = $hospilisation;
            $hospilisation->setChambre($this);
        }

        return $this;
    }

    public function removeHospilisation(Hospilisation $hospilisation): self
    {
        if ($this->hospilisations->removeElement($hospilisation)) {
            // set the owning side to null (unless already changed)
            if ($hospilisation->getChambre() === $this) {
                $hospilisation->setChambre(null);
            }
        }

        return $this;
    }
}
