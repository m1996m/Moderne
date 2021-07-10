<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Mapping\Annotation\Slug;
use PhpParser\Node\Expr\Cast\String_;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    public $confirmation;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */

    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class, inversedBy="users")
     */
    private $specialite;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="users")
     */
    private $service;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $assurance;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="patient")
     */
    private $rendezVouses;

    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="patient")
     */
    private $consultations;

    /**
     * @ORM\OneToMany(targetEntity=Traitement::class, mappedBy="patient")
     */
    private $traitements;

    /**
     * @ORM\OneToMany(targetEntity=CreatedAt::class, mappedBy="patient")
     */
    private $createdAts;

    /**
     * @ORM\OneToMany(targetEntity=Hospilisation::class, mappedBy="medecin")
     */
    private $hospilisations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     * @Gedmo\Slug(fields={"nom","tel"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
        $this->consultations = new ArrayCollection();
        $this->traitements = new ArrayCollection();
        $this->createdAts = new ArrayCollection();
        $this->hospilisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmation(): ?string
    {
        return $this->confirmation;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }


    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

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

    public function getAssurance(): ?string
    {
        return $this->assurance;
    }

    public function setAssurance(?string $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }

    /**
     * @return Collection|RendezVous[]
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses[] = $rendezVouse;
            $rendezVouse->setPatient($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getPatient() === $this) {
                $rendezVouse->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Consultation[]
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Traitement[]
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }

    public function addTraitement(Traitement $traitement): self
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements[] = $traitement;
            $traitement->setPatient($this);
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): self
    {
        if ($this->traitements->removeElement($traitement)) {
            // set the owning side to null (unless already changed)
            if ($traitement->getPatient() === $this) {
                $traitement->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CreatedAt[]
     */
    public function getCreatedAts(): Collection
    {
        return $this->createdAts;
    }

    public function addCreatedAt(CreatedAt $createdAt): self
    {
        if (!$this->createdAts->contains($createdAt)) {
            $this->createdAts[] = $createdAt;
            $createdAt->setPatient($this);
        }

        return $this;
    }

    public function removeCreatedAt(CreatedAt $createdAt): self
    {
        if ($this->createdAts->removeElement($createdAt)) {
            // set the owning side to null (unless already changed)
            if ($createdAt->getPatient() === $this) {
                $createdAt->setPatient(null);
            }
        }

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
            $hospilisation->setMedecin($this);
        }

        return $this;
    }

    public function removeHospilisation(Hospilisation $hospilisation): self
    {
        if ($this->hospilisations->removeElement($hospilisation)) {
            // set the owning side to null (unless already changed)
            if ($hospilisation->getMedecin() === $this) {
                $hospilisation->setMedecin(null);
            }
        }

        return $this;
    }
    public function usersPatient(string_$role): array
    {
        $entityManager = $this->getEntityManager;

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\User p
            WHERE p.roles = :roles
            ORDER BY p.nom ASC'
        )->setParameter('roles', $role);

        // returns an array of Product objects
        return $query->getResult();
    }
    public function __toString(): string
    {
        return $this->email;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
