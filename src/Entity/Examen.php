<?php

namespace App\Entity;

use App\Repository\ExamenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExamenRepository::class)
 */
class Examen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TypeExamen::class, inversedBy="examens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Examen::class, inversedBy="examens")
     */
    private $resultat;

    /**
     * @ORM\OneToMany(targetEntity=Examen::class, mappedBy="resultat")
     */
    private $examens;

    public function __construct()
    {
        $this->examens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?TypeExamen
    {
        return $this->type;
    }

    public function setType(?TypeExamen $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getResultat(): ?self
    {
        return $this->resultat;
    }

    public function setResultat(?self $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getExamens(): Collection
    {
        return $this->examens;
    }

    public function addExamen(self $examen): self
    {
        if (!$this->examens->contains($examen)) {
            $this->examens[] = $examen;
            $examen->setResultat($this);
        }

        return $this;
    }

    public function removeExamen(self $examen): self
    {
        if ($this->examens->removeElement($examen)) {
            // set the owning side to null (unless already changed)
            if ($examen->getResultat() === $this) {
                $examen->setResultat(null);
            }
        }

        return $this;
    }
}
