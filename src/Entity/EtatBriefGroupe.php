<?php

namespace App\Entity;

use App\Repository\EtatBriefGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatBriefGroupeRepository::class)
 */
class EtatBriefGroupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="etatBriefGroupes")
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="etatBriefGroupes")
     */
    private $groupes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    public function getGroupes(): ?Groupe
    {
        return $this->groupes;
    }

    public function setGroupes(?Groupe $groupes): self
    {
        $this->groupes = $groupes;

        return $this;
    }
}
