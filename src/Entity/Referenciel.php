<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ReferencielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *
 * @ORM\Entity(repositoryClass=ReferencielRepository::class)
 *@ApiResource(
 *   routePrefix="/admin/",
 *     normalizationContext={"groups"={"referenciel:read"}},
 *     denormalizationContext={"groups"={"referenciel:write"}},
 *
 *     collectionOperations={"GET",
 *     "get_groupe_competence"={
 *     "method"="GET",
 *     "path"="/referentiels/grpecompetences",
 *     "normalizationContext"={"groups"={"referencielgroupe:read"}},
 *     "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))"
 *     },
 *     "POST"},
 *     itemOperations={
 *     "GET"={
 *            "method":"GET",
 *           "path":"/referenciels/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM') or is_granted('ROLE_APPRENANT'))"
 *     },"PUT",
 *     }
 * )
 */
class Referenciel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"referenciel:read","formApprentReference:read","formReference:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"referenciel:read","referenciel:write","formApprentReference:read","formReference:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  @Groups ({"referenciel:read","referenciel:write","formApprentReference:read","formReference:read"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  @Groups ({"referenciel:read","referenciel:write","formReference:read"})
     */
    private $programme;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  @Groups ({"referenciel:read","referenciel:write","formReference:read"})
     */
    private $criteradmission;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  @Groups ({"referenciel:read","referenciel:write","formReference:read"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups ({"referenciel:read","referenciel:write","formReference:read"})
     */
    private $status = false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referenciels",cascade={"persist"})
     * @Groups ({"formReference:read","referenciel:read","referenciel:write","referencielgroupe:read"})
     * @ApiSubresource()
     */
    private $groupeCompetence;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="referenciels")
     */
    private $competencesValides;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="referenciels")
     */
    private $promos;





    public function __construct()
    {
        $this->groupeCompetence = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
        $this->promos = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(?string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCriteradmission(): ?string
    {
        return $this->criteradmission;
    }

    public function setCriteradmission(?string $criteradmission): self
    {
        $this->criteradmission = $criteradmission;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(?string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        $this->groupeCompetence->removeElement($groupeCompetence);

        return $this;
    }

    /**
     * @return Collection|CompetencesValides[]
     */
    public function getCompetencesValides(): Collection
    {
        return $this->competencesValides;
    }

    public function addCompetencesValide(CompetencesValides $competencesValide): self
    {
        if (!$this->competencesValides->contains($competencesValide)) {
            $this->competencesValides[] = $competencesValide;
            $competencesValide->setReferenciels($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->removeElement($competencesValide)) {
            // set the owning side to null (unless already changed)
            if ($competencesValide->getReferenciels() === $this) {
                $competencesValide->setReferenciels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addReferenciel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeReferenciel($this);
        }

        return $this;
    }




}
