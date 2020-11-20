<?php

namespace App\Entity;

use App\Repository\GroupeCompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 */
class GroupeCompetence
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
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences")
     */
    private $competenece;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptif;

    public function __construct()
    {
        $this->competenece = new ArrayCollection();
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
     * @return Collection|Competence[]
     */
    public function getCompetenece(): Collection
    {
        return $this->competenece;
    }

    public function addCompetenece(Competence $competenece): self
    {
        if (!$this->competenece->contains($competenece)) {
            $this->competenece[] = $competenece;
        }

        return $this;
    }

    public function removeCompetenece(Competence $competenece): self
    {
        $this->competenece->removeElement($competenece);

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }
}
