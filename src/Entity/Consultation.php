<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Mapping\Annotation\Slug;
/**
 * @ORM\Entity(repositoryClass=ConsultationRepository::class)
 */
class Consultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="consultations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="consultations")
     */
    private $medecin;

    /**
     * @ORM\OneToMany(targetEntity=Plainte::class, mappedBy="consultation")
     */
    private $plaintes;

    /**
     * @ORM\OneToMany(targetEntity=Allergie::class, mappedBy="consultation")
     */
    private $allergies;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fumeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alcoolique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $diabetique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autre;

    /**
     * @ORM\OneToMany(targetEntity=Examen::class, mappedBy="consultation")
     */
    private $examens;

    /**
     * @ORM\OneToMany(targetEntity=Ordonnance::class, mappedBy="consultation")
     */
    private $traitement;

    public function __construct()
    {
        $this->plaintes = new ArrayCollection();
        $this->allergies = new ArrayCollection();
        $this->examens = new ArrayCollection();
        $this->traitement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    /**
     * @return Collection|Plainte[]
     */
    public function getPlaintes(): Collection
    {
        return $this->plaintes;
    }

    public function addPlainte(Plainte $plainte): self
    {
        if (!$this->plaintes->contains($plainte)) {
            $this->plaintes[] = $plainte;
            $plainte->setConsultation($this);
        }

        return $this;
    }

    public function removePlainte(Plainte $plainte): self
    {
        if ($this->plaintes->removeElement($plainte)) {
            // set the owning side to null (unless already changed)
            if ($plainte->getConsultation() === $this) {
                $plainte->setConsultation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Allergie[]
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    public function addAllergy(Allergie $allergy): self
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies[] = $allergy;
            $allergy->setConsultation($this);
        }

        return $this;
    }

    public function removeAllergy(Allergie $allergy): self
    {
        if ($this->allergies->removeElement($allergy)) {
            // set the owning side to null (unless already changed)
            if ($allergy->getConsultation() === $this) {
                $allergy->setConsultation(null);
            }
        }

        return $this;
    }

    public function getFumeur(): string
    {
        return $this->fumeur;
    }

    public function setFumeur(string $fumeur): self
    {
        $this->fumeur = $fumeur;

        return $this;
    }

    public function getAlcoolique(): string
    {
        return $this->alcoolique;
    }

    public function setAlcoolique(string $alcoolique): self
    {
        $this->alcoolique = $alcoolique;

        return $this;
    }

    public function getDiabetique(): string
    {
        return $this->diabetique;
    }

    public function setDiabetique(string $diabetique): self
    {
        $this->diabetique = $diabetique;

        return $this;
    }

    public function getAutre(): ?string
    {
        return $this->autre;
    }

    public function setAutre(?string $autre): self
    {
        $this->autre = $autre;

        return $this;
    }
    public function __toString(): string
    {
        return $this->fumeur;
    }

    /**
     * @return Collection|Examen[]
     */
    public function getExamens(): Collection
    {
        return $this->examens;
    }

    public function addExamen(Examen $examen): self
    {
        if (!$this->examens->contains($examen)) {
            $this->examens[] = $examen;
            $examen->setConsultation($this);
        }

        return $this;
    }

    public function removeExamen(Examen $examen): self
    {
        if ($this->examens->removeElement($examen)) {
            // set the owning side to null (unless already changed)
            if ($examen->getConsultation() === $this) {
                $examen->setConsultation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ordonnance[]
     */
    public function getTraitement(): Collection
    {
        return $this->traitement;
    }

    public function addTraitement(Ordonnance $traitement): self
    {
        if (!$this->traitement->contains($traitement)) {
            $this->traitement[] = $traitement;
            $traitement->setConsultation($this);
        }

        return $this;
    }

    public function removeTraitement(Ordonnance $traitement): self
    {
        if ($this->traitement->removeElement($traitement)) {
            // set the owning side to null (unless already changed)
            if ($traitement->getConsultation() === $this) {
                $traitement->setConsultation(null);
            }
        }

        return $this;
    }

}
