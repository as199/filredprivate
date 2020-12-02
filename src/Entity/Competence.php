<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 *  * @ApiResource(
 * itemOperations={
 * "get_competence_id":{
 *   "method": "GET",
 *   "path": "/admin/competences/{id}",
 *   "normalization_context"={"groups":"competence:read"},
 *   "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *"updateCompetences":{
 *              "method":"PUT",
 *              "path": "/admin/competences/{id}",
 *              "route_name"="PutCompetence",
 *               "access_control"="(is_granted('ROLE_ADMIN') )",
 *
 *              },
 * },
 * collectionOperations={
 * "get_competences": {
 *   "method": "GET",
 *   "path": "/admin/competences",
 *   "normalization_context"={"groups":"competences:read"},
 *   "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT') or is_granted('ROLE_CM') or object==user)",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *
 * "add_competence": {
 *    "method": "POST",
 *    "path": "/admin/competences",
 *    "normalization_context"={"groups":"competence:read"},
 *    "access_control"="(is_granted('ROLE_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   }
 * }
 * )
 * @UniqueEntity ("libelle")
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"competence:read","gc:read","gcu:read","competences:read","gcf:read","referencielgroupe:read","referenciel:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"competence:read","gc:read","gcu:read","competences:read","gcf:read","referencielgroupe:read"})
     * @Assert\NotBlank (message="please enter the competence")
     */
    private $libelle;



    /**
     * @ORM\Column(type="boolean")
     *  @Groups ({"competence:read"})
     */
    private $status = false;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence",cascade={"persist"})
     * @Assert\Count(
     *      min = 3,
     *      max = 3,
     *      minMessage = "You must specify at least three levels",
     *      maxMessage = "You cannot specify more than {{ limit }} levels"
     * )
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competences")
     * @Groups ({"gc:read"})
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="competences")
     */
    private $competencesValides;

    public function __construct()
    {


        $this->niveau = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
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
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

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
            $competencesValide->setCompetences($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->removeElement($competencesValide)) {
            // set the owning side to null (unless already changed)
            if ($competencesValide->getCompetences() === $this) {
                $competencesValide->setCompetences(null);
            }
        }

        return $this;
    }
}
