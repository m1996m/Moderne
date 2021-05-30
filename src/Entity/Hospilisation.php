<?php

namespace App\Entity;

use App\Repository\HospilisationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HospilisationRepository::class)
 */
class Hospilisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="hospilisations")
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="hospilisations")
     */
    private $patient;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAdmission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motifAdmission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomAccompagnant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Motif::class, inversedBy="hospilisations")
     */
    private $motifSortie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Chambre::class, inversedBy="hospilisations")
     */
    private $chambre;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDateAdmission(): ?\DateTimeInterface
    {
        return $this->dateAdmission;
    }

    public function setDateAdmission(\DateTimeInterface $dateAdmission): self
    {
        $this->dateAdmission = $dateAdmission;

        return $this;
    }

    public function getMotifAdmission(): ?string
    {
        return $this->motifAdmission;
    }

    public function setMotifAdmission(string $motifAdmission): self
    {
        $this->motifAdmission = $motifAdmission;

        return $this;
    }

    public function getNomAccompagnant(): ?string
    {
        return $this->nomAccompagnant;
    }

    public function setNomAccompagnant(?string $nomAccompagnant): self
    {
        $this->nomAccompagnant = $nomAccompagnant;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getMotifSortie(): ?Motif
    {
        return $this->motifSortie;
    }

    public function setMotifSortie(?Motif $motifSortie): self
    {
        $this->motifSortie = $motifSortie;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }
}
