<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 */
class Marque
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"detail:tel","detail:marque"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste:tel","detail:tel","detail:marque"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Telephone", mappedBy="marque")
     * @Groups({"detail:marque"})
     */
    private $telephones;

    /**
     * @Groups({"liste:tel","detail:tel"})
     * @var string
     */
    private $lien_marque;

    public function __construct()
    {
        $this->telephones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Telephone[]
     */
    public function getTelephones(): Collection
    {
        return $this->telephones;
    }

    public function addTelephone(Telephone $telephone): self
    {
        if (!$this->telephones->contains($telephone)) {
            $this->telephones[] = $telephone;
            $telephone->setMarque($this);
        }

        return $this;
    }

    public function removeTelephone(Telephone $telephone): self
    {
        if ($this->telephones->contains($telephone)) {
            $this->telephones->removeElement($telephone);
            // set the owning side to null (unless already changed)
            if ($telephone->getMarque() === $this) {
                $telephone->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLienMarque(){
        return '/api/marque/show/'.$this->id;
    }
}
