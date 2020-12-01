<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApprenantRepository", repositoryClass=ApprenantRepository::class)
 * @ApiResource(attributes={"pagination_enabled"=true,"pagination_items_per_page"=1,},
 *     itemOperations={
 *     "get_apprenant_id":{
 *           "method":"get",
 *          "path":"/apprenants/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN')  or is_granted('ROLE_FORMATEUR') or object==user or is_granted('ROLE_APPRENANT'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          },"put_apprenant_id":{
 *           "method":"put",
 *          "path":"/apprenants/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          }},
 *     collectionOperations={
 *     "get":{
 *              "path":"/apprenants",
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')or is_granted('ROLE_CM') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "deserialize" = false
 *          },
 *     "addApprenant":{"method":"post",
 *              "path":"/apprenants",
 *               "deserialize" = false
 *              }
 *
 *      }
 * )
 */
class Apprenant extends User
{
    /**
     * @ORM\ManyToOne(targetEntity=ProfilSorti::class, inversedBy="apprenants")
     */
    private $profilSorti;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="apprenants")
     */
    private $groupes;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
    }

    public function getProfilSorti(): ?ProfilSorti
    {
        return $this->profilSorti;
    }

    public function setProfilSorti(?ProfilSorti $profilSorti): self
    {
        $this->profilSorti = $profilSorti;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeApprenant($this);
        }

        return $this;
    }
}
