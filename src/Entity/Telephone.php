<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelephoneRepository")
 */
class Telephone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"liste:tel","detail:tel"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:tel")
     */
    private $os;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste:tel","detail:tel","detail:marque"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:tel")
     */
    private $coloris;

    /**
     * @ORM\Column(type="date")
     * @Groups("detail:tel")
     */
    private $dateSortie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:tel")
     */
    private $memoire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:tel")
     */
    private $tailleEcran;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("detail:tel")
     */
    private $photo;

    /**
     * @ORM\Column(type="float")
     * @Groups({"liste:tel","detail:tel"})
     */
    private $prix;

    /**
     * @Groups({"liste:tel"})
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="telephones")
     * @Groups({"liste:tel","detail:tel"})
     */
    private $marque;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(string $os): self
    {
        $this->os = $os;

        return $this;
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

    public function getColoris(): ?string
    {
        return $this->coloris;
    }

    public function setColoris(string $coloris): self
    {
        $this->coloris = $coloris;

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

    public function getMemoire(): ?string
    {
        return $this->memoire;
    }

    public function setMemoire(string $memoire): self
    {
        $this->memoire = $memoire;

        return $this;
    }

    public function getTailleEcran(): ?string
    {
        return $this->tailleEcran;
    }

    public function setTailleEcran(string $tailleEcran): self
    {
        $this->tailleEcran = $tailleEcran;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return string
     */
    public function getDetails(){
        return '/api/telephones/show/'.$this->id;
    }
}
