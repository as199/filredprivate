<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource (
 *     routePrefix="/admin/",
 *     normalizationContext={"groups"={"promo:read"}},
 *     itemOperations={
 *          "GETRefFormGroup"={
 *               "path":"/promo/{id}",
 *                "method":"GET",
 *                 "normalizationContext"={"groups"={"RefFormGroup:read"}},
 *             }
 *          ,"DELETE","PUT"},
 *     collectionOperations={
 *          "promoapprenant"={
 *              "method":"GET",
 *              "path":"/promo/principal",
 *              "normalizationContext"={"groups"={"promoapprenant:read"}},
 *          },
 *          "formateurapprenant"={
 *               "method":"GET",
 *               "path":"/promo/",
 *               "normalizationContext"={"groups"={"formateurapprenant:read"}},
 *           },
 *           "addpromo"={
 *               "method":"POST",
 *                "path":"/promo",
 *                "denormalizationContext"={"groups"={"promo:write"}},
 *            }
 *      }
 * )
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"promo:read","promoapprenant:read","RefFormGroup:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"promo:read","promo:write","promoapprenant:read","RefFormGroup:read"})
     */
    private $nomPromo;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"promo:read","promo:write"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"promo:read","promo:write"})
     */
    private $titre;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups ({"promo:write"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"promo:read","promo:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"promo:read","promo:write"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="date")
     *  @Groups ({"promo:read","promo:write"})
     */
    private $dateFinProvisoire;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ({"promo:read","promo:write"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="date")
     * @Groups ({"admin_groupe:read"})
     *  @Groups ({"promo:read","promo:write"})
     */
    private $dateFinReel;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promos", cascade={"persist"})
     *  @Groups ({"promo:read","promo:write","promoapprenant:read","RefFormGroup:read"})
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="promos", cascade={"persist"})
     */
    private $competencesValides;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="promos", cascade={"persist"})
     */
    private $chats;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="promos", cascade={"persist"})
     */
    private $briefMaPromos;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
        $this->chats = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPromo(): ?string
    {
        return $this->nomPromo;
    }

    public function setNomPromo(string $nomPromo): self
    {
        $this->nomPromo = $nomPromo;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateFinProvisoire(): ?\DateTimeInterface
    {
        return $this->dateFinProvisoire;
    }

    public function setDateFinProvisoire(\DateTimeInterface $dateFinProvisoire): self
    {
        $this->dateFinProvisoire = $dateFinProvisoire;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateFinReel(): ?\DateTimeInterface
    {
        return $this->dateFinReel;
    }

    public function setDateFinReel(\DateTimeInterface $dateFinReel): self
    {
        $this->dateFinReel = $dateFinReel;

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
            $groupe->setPromos($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromos() === $this) {
                $groupe->setPromos(null);
            }
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
            $competencesValide->setPromos($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->removeElement($competencesValide)) {
            // set the owning side to null (unless already changed)
            if ($competencesValide->getPromos() === $this) {
                $competencesValide->setPromos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setPromos($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getPromos() === $this) {
                $chat->setPromos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefMaPromos(): Collection
    {
        return $this->briefMaPromos;
    }

    public function addBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if (!$this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos[] = $briefMaPromo;
            $briefMaPromo->setPromos($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->removeElement($briefMaPromo)) {
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getPromos() === $this) {
                $briefMaPromo->setPromos(null);
            }
        }

        return $this;
    }
}
