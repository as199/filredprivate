<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource (itemOperations={
 *                  "get_formateur_id":{
*                       "method":"get",
 *                      "path":"/formateurs/{id}",
 *                       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *                       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *                    },
 *                  "put_formateur_id":{
 *                       "method":"put",
 *                      "path":"/formateurs/{id}",
 *                       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *                       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *                    }
*               },
 *     collectionOperations={
 *          "get":{
 *              "path":"/formateurs",
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')or is_granted('ROLE_CM') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *               },
 *      }
 *     )
 */
class Formateur extends User
{
    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="formateurs")
     */
    private $groupes;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
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
            $groupe->addFormateur($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeFormateur($this);
        }

        return $this;
    }
}
