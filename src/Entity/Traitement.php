<?php

namespace App\Entity;

use App\Repository\TraitementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Mapping\Annotation\Slug;

/**
 * @ORM\Entity(repositoryClass=TraitementRepository::class)
 */
class Traitement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="traitements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="traitements")
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTraitement::class, inversedBy="traitements")
    */
    private $type;

    /**
     * @ORM\Column(type="date")
     */
    private $debut;

    /**
     * @ORM\Column(type="date")
     */
    private $fin;

    /**
     * @ORM\OneToMany(targetEntity=Ordonnance::class, mappedBy="traitement")
     */
    private $ordonnances;

    public function __construct()
    {
        $this->ordonnances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getMedecin(): ?User
    {
        return $this->medecin;
    }

    public function setMedecin(?User $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getType(): ?TypeTraitement
    {
        return $this->type;
    }

    public function setType(?TypeTraitement $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * @return Collection|Ordonnance[]
     */
    public function getOrdonnances(): Collection
    {
        return $this->ordonnances;
    }

    public function addOrdonnance(Ordonnance $ordonnance): self
    {
        if (!$this->ordonnances->contains($ordonnance)) {
            $this->ordonnances[] = $ordonnance;
            $ordonnance->setTraitement($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): self
    {
        if ($this->ordonnances->removeElement($ordonnance)) {
            // set the owning side to null (unless already changed)
            if ($ordonnance->getTraitement() === $this) {
                $ordonnance->setTraitement(null);
            }
        }

        return $this;
    }

}
