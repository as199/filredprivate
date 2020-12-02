<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 ** @ApiResource(
 *  collectionOperations={
 *      "get":{
 *          "path":"admin/groupes",
 *          "normalization_context"={"groups":"admin_groupe:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 *      "recuper_apprenant_groupe":{
 *          "method":"get",
 *          "path":"admin/groupes/apprenants",
 *          "normalization_context"={"groups":"admin_groupe_apprenant:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *      },
 *      "addGroupe":{
 *              "method":"POST",
 *              "route_name"="addingGroupe",
 *               "access_control"="(is_granted('ROLE_ADMIN') )",
 *              }
 *  },
 *  itemOperations={
 *      "get":{
 *          "path":"admin/groupes/{id}",
 *          "normalization_context"={"groups":"admin_groupe:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 *     "putGroupe":{
 *              "method":"POST",
 *              "route_name"="putingGroupe",
 *                "normalization_context"={"groups":"admin_groupe_id:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *               "access_control"="(is_granted('ROLE_ADMIN') )",
 *              },
 *      "deleteApprenantGroupe":{
 *          "route_name":"deletingApprenantGroupe",
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *      }
 *  }
 * )
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"admin_groupe:read","promo:read","promo:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"admin_groupe:read","promo:read","promo:write"})
     */
    private $nomGroupe;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups ({"admin_groupe:read"})
     */
    private $status ;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes", cascade={"persist"})
     *  @Groups ({"admin_groupe:read","promo:read","promo:write","promoapprenant:read"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes", cascade={"persist"})
     *  @Groups ({"admin_groupe:read","RefFormGroup:read"})
     *
     */
    private $formateurs;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes", cascade={"persist"})
     *  @Groups ({"admin_groupe:read"})
     */
    private $promos;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="groupes", cascade={"persist"})
     */
    private $etatBriefGroupes;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->etatBriefGroupes = new ArrayCollection();
        $this->dateCreation = new \DateTime("now");
        $this->status =false;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGroupe(): ?string
    {
        return $this->nomGroupe;
    }

    public function setNomGroupe(string $nomGroupe): self
    {
        $this->nomGroupe = $nomGroupe;

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
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->apprenants->removeElement($apprenant);

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateurs->removeElement($formateur);

        return $this;
    }

    public function getPromos(): ?Promo
    {
        return $this->promos;
    }

    public function setPromos(?Promo $promos): self
    {
        $this->promos = $promos;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatBriefGroupes(): Collection
    {
        return $this->etatBriefGroupes;
    }

    public function addEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if (!$this->etatBriefGroupes->contains($etatBriefGroupe)) {
            $this->etatBriefGroupes[] = $etatBriefGroupe;
            $etatBriefGroupe->setGroupes($this);
        }

        return $this;
    }

    public function removeEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if ($this->etatBriefGroupes->removeElement($etatBriefGroupe)) {
            // set the owning side to null (unless already changed)
            if ($etatBriefGroupe->getGroupes() === $this) {
                $etatBriefGroupe->setGroupes(null);
            }
        }

        return $this;
    }
}
