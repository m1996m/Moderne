<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rendezVouses")
     */
    private $patient;
    private $heures;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rendezVouses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medecin;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="rendezVouses")
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Examen::class, inversedBy="rendezVouses")
     */
    private $resultat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heure;

    /**
     * @ORM\Column(type="integer")
     */
    private $disponibilite;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getResultat(): ?Examen
    {
        return $this->resultat;
    }

    public function setResultat(?Examen $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function getHeures(): ?string
    {
        return $this->heures;
    }

    public function setHeure(string $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getDisponibilite(): ?int
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(int $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }
}
