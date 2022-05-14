<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 */
class Hotel
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;



    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="hotel")
     */
    private $photos;

    /**
     * @ORM\ManyToMany(targetEntity=Offre::class, mappedBy="hotels")
     */
    private $offres;

    /**
     * @ORM\ManyToMany(targetEntity=GrilleTarifaire::class, mappedBy="hotelgrille")
     */
    private $grilleTarifaires;

    /**
     * @ORM\Column(type="array")
     */
    private $photo = [];

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="hotels")
     */
    private $pays;

  


    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->offres = new ArrayCollection();
        $this->grilleTarifaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }



    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setHotel($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getHotel() === $this) {
                $photo->setHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->addHotel($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            $offre->removeHotel($this);
        }

        return $this;
    }

    /**
     * @return Collection|GrilleTarifaire[]
     */
    public function getGrilleTarifaires(): Collection
    {
        return $this->grilleTarifaires;
    }

    public function addGrilleTarifaire(GrilleTarifaire $grilleTarifaire): self
    {
        if (!$this->grilleTarifaires->contains($grilleTarifaire)) {
            $this->grilleTarifaires[] = $grilleTarifaire;
            $grilleTarifaire->addHotelgrille($this);
        }

        return $this;
    }

    public function removeGrilleTarifaire(GrilleTarifaire $grilleTarifaire): self
    {
        if ($this->grilleTarifaires->removeElement($grilleTarifaire)) {
            $grilleTarifaire->removeHotelgrille($this);
        }

        return $this;
    }

    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    public function setPhoto(array $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

   
}
