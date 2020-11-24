<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
 * "update_competence_id":{
 *   "method": "PUT",
 *   "path": "/admin/competences/{id}",
 *   "normalization_context"={"groups":"competence:read"},
 *   "access_control"="(is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * },
 * collectionOperations={
 * "get_competences": {
 *   "method": "GET",
 *   "path": "/admin/competences",
 *   "normalization_context"={"groups":"competences:read"},
 *   "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT') or is_granted('ROLE_CM') or object==user)",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * "add_competence": {
 *    "method": "POST",
 *    "path": "/admin/competences",
 *    "normalization_context"={"groups":"competence:read"},
 *    "access_control"="(is_granted('ROLE_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   }
 * }
 * )
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"competence:read","gc:read","competences:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"competence:read","gc:read","competences:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competenece")
     */
    private $groupeCompetences;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups ({"competence:read"})
     */
    private $status;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
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
            $groupeCompetence->addCompetenece($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetenece($this);
        }

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
}
