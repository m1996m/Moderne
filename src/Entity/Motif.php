<?php

namespace App\Entity;

use App\Repository\MotifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotifRepository::class)
 */
class Motif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity=Hospilisation::class, mappedBy="motifSortie")
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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

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
            $hospilisation->setMotifSortie($this);
        }

        return $this;
    }

    public function removeHospilisation(Hospilisation $hospilisation): self
    {
        if ($this->hospilisations->removeElement($hospilisation)) {
            // set the owning side to null (unless already changed)
            if ($hospilisation->getMotifSortie() === $this) {
                $hospilisation->setMotifSortie(null);
            }
        }

        return $this;
    }
}
