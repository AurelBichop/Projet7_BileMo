<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields={"email"},message="Cet utilisateur existe déja")
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"liste:utilisateur","detail:utilisateur"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste:utilisateur","detail:utilisateur","docPost:utilisateur"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="255")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste:utilisateur","detail:utilisateur","docPost:utilisateur"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="255")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"detail:utilisateur","docPost:utilisateur"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="255")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"detail:utilisateur","docPost:utilisateur"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="255")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"detail:utilisateur","docPost:utilisateur"})
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message="L'email n'est pas un email valide"
     * )
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="utilisateurs")
     */
    private $client;

    /**
     * @Groups({"liste:utilisateur"})
     * @var string
     */
    private $details;

    /**
     * @Groups({"detail:utilisateur"})
     * @var string
     */
    private $manage;


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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Lien pour le detail de l'utilisateur
     * @return string
     */
    public function getDetails(){
        return '/api/utilisateurs/show/'.$this->id;
    }

    /**
     * Lien pour la mise à jour ou suppression
     * @return string
     */
    public function getManage(){
        return '/api/utilisateurs/'.$this->id;
    }

}
